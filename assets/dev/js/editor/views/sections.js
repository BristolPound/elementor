var SectionView = require( 'wroter-views/section' ),
	SectionsCollectionView;

SectionsCollectionView = Marionette.CompositeView.extend( {
	template: Marionette.TemplateCache.get( '#tmpl-wroter-preview' ),

	id: 'wroter-inner',

	childViewContainer: '#wroter-section-wrap',

	childView: SectionView,

	ui: {
		addSectionArea: '#wroter-add-section',
		addNewSection: '#wroter-add-new-section',
		closePresetsIcon: '#wroter-select-preset-close',
		addSectionButton: '#wroter-add-section-button',
		addTemplateButton: '#wroter-add-template-button',
		selectPreset: '#wroter-select-preset',
		presets: '.wroter-preset'
	},

	events: {
		'click @ui.addSectionButton': 'onAddSectionButtonClick',
		'click @ui.addTemplateButton': 'onAddTemplateButtonClick',
		'click @ui.closePresetsIcon': 'closeSelectPresets',
		'click @ui.presets': 'onPresetSelected'
	},

	behaviors: {
		Sortable: {
			behaviorClass: require( 'wroter-behaviors/sortable' ),
			elChildType: 'section'
		},
		HandleDuplicate: {
			behaviorClass: require( 'wroter-behaviors/handle-duplicate' )
		},
		HandleAdd: {
			behaviorClass: require( 'wroter-behaviors/duplicate' )
		},
		HandleElementsRelation: {
			behaviorClass: require( 'wroter-behaviors/elements-relation' )
		}
	},

	getSortableOptions: function() {
		return {
			handle: '> .wroter-container > .wroter-row > .wroter-column > .wroter-element-overlay .wroter-editor-section-settings-list .wroter-editor-element-trigger',
			items: '> .wroter-section'
		};
	},

	getChildType: function() {
		return [ 'section' ];
	},

	isCollectionFilled: function() {
		return false;
	},

	initialize: function() {
		this
			.listenTo( this.collection, 'add remove reset', this.onCollectionChanged )
			.listenTo( wroter.channels.panelElements, 'element:drag:start', this.onPanelElementDragStart )
			.listenTo( wroter.channels.panelElements, 'element:drag:end', this.onPanelElementDragEnd );
	},

	addChildModel: function( model, options ) {
		return this.collection.add( model, options, true );
	},

	addSection: function( properties ) {
		var newSection = {
			id: wroter.helpers.getUniqueID(),
			elType: 'section',
			settings: {},
			elements: []
		};

		if ( properties ) {
			_.extend( newSection, properties );
		}

		var newModel = this.addChildModel( newSection );

		return this.children.findByModelCid( newModel.cid );
	},

	closeSelectPresets: function() {
		this.ui.addNewSection.show();
		this.ui.selectPreset.hide();
	},

	fixBlankPageOffset: function() {
		var sectionHandleHeight = 27,
			elTopOffset = this.$el.offset().top,
			elTopOffsetRange = sectionHandleHeight - elTopOffset;

		if ( 0 < elTopOffsetRange ) {
			var $style = Backbone.$( '<style>' ).text( '.wroter-editor-active #wroter-inner{margin-top: ' + elTopOffsetRange + 'px}' );

			wroter.$previewContents.children().children( 'head' ).append( $style );
		}
	},

	onAddSectionButtonClick: function() {
		this.ui.addNewSection.hide();
		this.ui.selectPreset.show();
	},

	onAddTemplateButtonClick: function() {
		wroter.templates.startModal( function() {
			wroter.templates.showTemplates();
		} );
	},

	onRender: function() {
		var self = this;

		self.ui.addSectionArea.html5Droppable( {
			axis: [ 'vertical' ],
			groups: [ 'wroter-element' ],
			onDragEnter: function( side ) {
				self.ui.addSectionArea.attr( 'data-side', side );
			},
			onDragLeave: function() {
				self.ui.addSectionArea.removeAttr( 'data-side' );
			},
			onDropping: function() {
				var elementView = wroter.channels.panelElements.request( 'element:selected' ),
					newSection = self.addSection(),
					elType = elementView.model.get( 'elType' );

				var elementData = {
					id: wroter.helpers.getUniqueID(),
					elType: elType
				};

				if ( 'widget' === elType ) {
					elementData.widgetType = elementView.model.get( 'widgetType' );
				} else {
					elementData.elements = [];
					elementData.isInner = true;
				}

				newSection.triggerMethod( 'request:add', elementData );
			}
		} );

		_.defer( _.bind( self.fixBlankPageOffset, this ) );
	},

	onCollectionChanged: function() {
		wroter.setFlagEditorChange( true );
	},

	onPresetSelected: function( event ) {
		this.closeSelectPresets();

		var selectedStructure = event.currentTarget.dataset.structure,
			parsedStructure = wroter.presetsFactory.getParsedStructure( selectedStructure ),
			elements = [],
			loopIndex;

		for ( loopIndex = 0; loopIndex < parsedStructure.columnsCount; loopIndex++ ) {
			elements.push( {
				id: wroter.helpers.getUniqueID(),
				elType: 'column',
				settings: {},
				elements: []
			} );
		}

		var newSection = this.addSection( { elements: elements } );

		newSection.setStructure( selectedStructure );
		newSection.redefineLayout();
	},

	onPanelElementDragStart: function() {
		wroter.helpers.disableElementEvents( this.$el.find( 'iframe' ) );
	},

	onPanelElementDragEnd: function() {
		wroter.helpers.enableElementEvents( this.$el.find( 'iframe' ) );
	}
} );

module.exports = SectionsCollectionView;
