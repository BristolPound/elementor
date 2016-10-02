var BaseElementView = require( 'wroter-views/base-element' ),
	ElementEmptyView = require( 'wroter-views/element-empty' ),
	WidgetView = require( 'wroter-views/widget' ),
	ColumnView;

ColumnView = BaseElementView.extend( {
	template: Marionette.TemplateCache.get( '#tmpl-wroter-element-column-content' ),

	elementEvents: {
		'click > .wroter-element-overlay .wroter-editor-column-settings-list .wroter-editor-element-remove': 'onClickRemove',
		'click @ui.listTriggers': 'onClickTrigger'
	},

	getChildView: function( model ) {
		if ( 'section' === model.get( 'elType' ) ) {
			return require( 'wroter-views/section' ); // We need to require the section dynamically
		}

		return WidgetView;
	},

	emptyView: ElementEmptyView,

	className: function() {
		var classes = 'wroter-column',
			type = this.isInner() ? 'inner' : 'top';

		classes += ' wroter-' + type + '-column';

		return classes;
	},

	childViewContainer: '> .wroter-column-wrap > .wroter-widget-wrap',

	triggers: {
		'click > .wroter-element-overlay .wroter-editor-column-settings-list .wroter-editor-element-add': 'click:new',
		'click > .wroter-element-overlay .wroter-editor-column-settings-list .wroter-editor-element-edit': 'click:edit',
		'click > .wroter-element-overlay .wroter-editor-column-settings-list .wroter-editor-element-trigger': 'click:edit',
		'click > .wroter-element-overlay .wroter-editor-column-settings-list .wroter-editor-element-duplicate': 'click:duplicate'
	},

	ui: {
		columnTitle: '.column-title',
		columnInner: '> .wroter-column-wrap',
		listTriggers: '> .wroter-element-overlay .wroter-editor-element-trigger'
	},

	behaviors: {
		Sortable: {
			behaviorClass: require( 'wroter-behaviors/sortable' ),
			elChildType: 'widget'
		},
		Resizable: {
			behaviorClass: require( 'wroter-behaviors/resizable' )
		},
		HandleDuplicate: {
			behaviorClass: require( 'wroter-behaviors/handle-duplicate' )
		},
		HandleEditor: {
			behaviorClass: require( 'wroter-behaviors/handle-editor' )
		},
		HandleEditMode: {
			behaviorClass: require( 'wroter-behaviors/handle-edit-mode' )
		},
		HandleAddMode: {
			behaviorClass: require( 'wroter-behaviors/duplicate' )
		},
		HandleElementsRelation: {
			behaviorClass: require( 'wroter-behaviors/elements-relation' )
		}
	},

	initialize: function() {
		BaseElementView.prototype.initialize.apply( this, arguments );

		this.listenTo( wroter.channels.data, 'widget:drag:start', this.onWidgetDragStart );
		this.listenTo( wroter.channels.data, 'widget:drag:end', this.onWidgetDragEnd );
	},

	isDroppingAllowed: function( side, event ) {
		var elementView = wroter.channels.panelElements.request( 'element:selected' ),
			elType = elementView.model.get( 'elType' );

		if ( 'section' === elType ) {
			return ! this.isInner();
		}

		return 'widget' === elType;
	},

	changeSizeUI: function() {
		var columnSize = this.model.getSetting( '_column_size' ),
			inlineSize = this.model.getSetting( '_inline_size' ),
			columnSizeTitle = parseFloat( inlineSize || columnSize ).toFixed( 1 ) + '%';

		this.$el.attr( 'data-col', columnSize );

		this.ui.columnTitle.html( columnSizeTitle );
	},

	getSortableOptions: function() {
		return {
			connectWith: '.wroter-widget-wrap',
			items: '> .wroter-element'
		};
	},

	// Events
	onCollectionChanged: function() {
		BaseElementView.prototype.onCollectionChanged.apply( this, arguments );

		this.changeChildContainerClasses();
	},

	changeChildContainerClasses: function() {
		var emptyClass = 'wroter-element-empty',
			populatedClass = 'wroter-element-populated';

		if ( this.collection.isEmpty() ) {
			this.ui.columnInner.removeClass( populatedClass ).addClass( emptyClass );
		} else {
			this.ui.columnInner.removeClass( emptyClass ).addClass( populatedClass );
		}
	},

	onRender: function() {
		var self = this;

		self.changeChildContainerClasses();
		self.changeSizeUI();

		self.$el.html5Droppable( {
			items: ' > .wroter-column-wrap > .wroter-widget-wrap > .wroter-element, >.wroter-column-wrap > .wroter-widget-wrap > .wroter-empty-view > .wroter-first-add',
			axis: [ 'vertical' ],
			groups: [ 'wroter-element' ],
			isDroppingAllowed: _.bind( self.isDroppingAllowed, self ),
			onDragEnter: function() {
				self.$el.addClass( 'wroter-dragging-on-child' );
			},
			onDragging: function( side, event ) {
				event.stopPropagation();

				if ( this.dataset.side !== side ) {
					Backbone.$( this ).attr( 'data-side', side );
				}
			},
			onDragLeave: function() {
				self.$el.removeClass( 'wroter-dragging-on-child' );

				Backbone.$( this ).removeAttr( 'data-side' );
			},
			onDropping: function( side, event ) {
				event.stopPropagation();

				var elementView = wroter.channels.panelElements.request( 'element:selected' ),
					newIndex = Backbone.$( this ).index();

				if ( 'bottom' === side ) {
					newIndex++;
				}

				var itemData = {
					id: wroter.helpers.getUniqueID(),
					elType: elementView.model.get( 'elType' )
				};

				if ( 'widget' === itemData.elType ) {
					itemData.widgetType = elementView.model.get( 'widgetType' );
				} else if ( 'section' === itemData.elType ) {
					itemData.elements = [];
					itemData.isInner = true;
				} else {
					return;
				}

				self.triggerMethod( 'request:add', itemData, { at: newIndex } );
			}
		} );
	},

	onClickTrigger: function( event ) {
		event.preventDefault();

		var $trigger = this.$( event.currentTarget ),
			isTriggerActive = $trigger.hasClass( 'wroter-active' );

		this.ui.listTriggers.removeClass( 'wroter-active' );

		if ( ! isTriggerActive ) {
			$trigger.addClass( 'wroter-active' );
		}
	},

	onWidgetDragStart: function() {
		this.$el.addClass( 'wroter-dragging' );
	},

	onWidgetDragEnd: function() {
		this.$el.removeClass( 'wroter-dragging' );
	}
} );

module.exports = ColumnView;
