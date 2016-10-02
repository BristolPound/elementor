var EditorCompositeView;

EditorCompositeView = Marionette.CompositeView.extend( {
	template: Marionette.TemplateCache.get( '#tmpl-editor-content' ),

	id: 'wroter-panel-page-editor',

	templateHelpers: function() {
		return {
			elementData: wroter.getElementData( this.model )
		};
	},

	childViewContainer: 'div.wroter-controls',

	modelEvents: {
		'destroy': 'onModelDestroy'
	},

	ui: {
		'tabs': '.wroter-tabs-controls li'
	},

	events: {
		'click @ui.tabs a': 'onClickTabControl'
	},

	initialize: function() {
		this.listenTo( wroter.channels.deviceMode, 'change', this.onDeviceModeChange );
	},

	getChildView: function( item ) {
		var controlType = item.get( 'type' );
		return wroter.getControlItemView( controlType );
	},

	childViewOptions: function() {
		return {
			elementSettingsModel: this.model.get( 'settings' ),
			elementEditSettings: this.model.get( 'editSettings' )
		};
	},

	onDestroy: function() {
		this.getOption( 'editedElementView' ).$el.removeClass( 'wroter-element-editable' );
		this.model.trigger( 'editor:close' );

		this.triggerMethod( 'editor:destroy' );
	},

	onBeforeRender: function() {
		var controls = wroter.getElementControls( this.model.get( 'settings' ) );

		if ( ! controls ) {
			throw new Error( 'Editor controls not found' );
		}

		// Create new instance of that collection
		this.collection = new Backbone.Collection( controls );
	},

	onRender: function() {
		this.getOption( 'editedElementView' ).$el.addClass( 'wroter-element-editable' );

		// Set the first tab as active
		this.ui.tabs.eq( 0 ).find( 'a' ).trigger( 'click' );

		// Create tooltip on controls
		this.$( '.tooltip-target' ).tipsy( {
			gravity: function() {
				// `n` for down, `s` for up
				var gravity = Backbone.$( this ).data( 'tooltip-pos' );

				if ( undefined !== gravity ) {
					return gravity;
				} else {
					return 'n';
				}
			},
			title: function() {
				return this.getAttribute( 'data-tooltip' );
			}
		} );
	},

	onModelDestroy: function() {
		this.destroy();
	},

	onClickTabControl: function( event ) {
		event.preventDefault();

		var $thisTab = this.$( event.target );

		this.ui.tabs.removeClass( 'active' );
		$thisTab.closest( 'li' ).addClass( 'active' );

		this.model.get( 'settings' ).trigger( 'control:switch:tab', $thisTab.data( 'tab' ) );

		this.openFirstSectionInCurrentTab( $thisTab.data( 'tab' ) );
	},

	onDeviceModeChange: function() {
		var self = this;

		self.$el.removeClass( 'wroter-responsive-switchers-open' );

		// Timeout according to preview resize css animation duration
		setTimeout( function() {
			wroter.$previewContents.find( 'html, body' ).animate( {
				scrollTop: self.getOption( 'editedElementView' ).$el.offset().top - wroter.$preview[0].contentWindow.innerHeight / 2
			} );
		}, 500 );
	},

	/**
	 * It's a temp method.
	 *
	 * TODO: Rewrite this method later.
	 */
	openFirstSectionInCurrentTab: function( currentTab ) {
		var openedClass = 'wroter-open',

			childrenUnderSection = this.children.filter( function( view ) {
				return ( ! _.isEmpty( view.model.get( 'section' ) ) );
			} ),

			firstSectionControlView = this.children.filter( function( view ) {
				return ( 'section' === view.model.get( 'type' ) ) && ( currentTab === view.model.get( 'tab' ) );
			} );

		// Check if found any section controls
		if ( _.isEmpty( firstSectionControlView ) ) {
			return;
		}

		firstSectionControlView = firstSectionControlView[0];
		firstSectionControlView.ui.heading.addClass( openedClass );

		_.each( childrenUnderSection, function( view ) {
			if ( view.model.get( 'section' ) !== firstSectionControlView.model.get( 'name' ) ) {
				view.$el.removeClass( openedClass );
				return;
			}

			view.$el.addClass( openedClass );
		} );
	},

	onChildviewControlSectionClicked: function( childView ) {
		var openedClass = 'wroter-open',
			sectionClicked = childView.model.get( 'name' ),
			isSectionOpen = childView.ui.heading.hasClass( openedClass ),

			childrenUnderSection = this.children.filter( function( view ) {
				return ( ! _.isEmpty( view.model.get( 'section' ) ) );
			} );

		this.$( '.wroter-control.wroter-control-type-section .wroter-panel-heading' ).removeClass( openedClass );

		if ( isSectionOpen ) {
			// Close all open sections
			sectionClicked = '';
		} else {
			childView.ui.heading.addClass( openedClass );
		}

		_.each( childrenUnderSection, function( view ) {
			if ( view.model.get( 'section' ) !== sectionClicked ) {
				view.$el.removeClass( openedClass );
				return;
			}

			view.$el.addClass( openedClass );
		} );

		wroter.channels.data.trigger( 'scrollbar:update' );
	}
} );

module.exports = EditorCompositeView;
