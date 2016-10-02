var EditModeItemView = require( 'wroter-layouts/edit-mode' ),
	PanelLayoutView;

PanelLayoutView = Marionette.LayoutView.extend( {
	template: '#tmpl-wroter-panel',

	id: 'wroter-panel-inner',

	regions: {
		content: '#wroter-panel-content-wrapper',
		header: '#wroter-panel-header-wrapper',
		footer: '#wroter-panel-footer',
		modeSwitcher: '#wroter-mode-switcher'
	},

	pages: {},

	childEvents: {
		'click:add': function() {
			this.setPage( 'elements' );
		},
		'editor:destroy': function() {
			this.setPage( 'elements' );
		}
	},

	currentPageName: null,

	_isScrollbarInitialized: false,

	initialize: function() {
		this.initPages();
	},

	initPages: function() {
		var pages = {
			elements: {
				view: require( 'wroter-panel/pages/elements/elements' ),
				title: '<img src="' + wroter.config.assets_url + 'images/logo-panel.svg">'
			},
			editor: {
				view: require( 'wroter-panel/pages/editor' )
			},
			menu: {
				view: require( 'wroter-panel/pages/menu/menu' ),
				title: '<img src="' + wroter.config.assets_url + 'images/logo-panel.svg">'
			},
			colorScheme: {
				view: require( 'wroter-panel/pages/schemes/colors' )
			},
			typographyScheme: {
				view: require( 'wroter-panel/pages/schemes/typography' )
			}
		};

		var schemesTypes = Object.keys( wroter.schemes.getSchemes() ),
			disabledSchemes = _.difference( schemesTypes, wroter.schemes.getEnabledSchemesTypes() );

		_.each( disabledSchemes, function( schemeType ) {
			var scheme  = wroter.schemes.getScheme( schemeType );

			pages[ schemeType + 'Scheme' ].view = require( 'wroter-panel/pages/schemes/disabled' ).extend( {
				disabledTitle: scheme.disabled_title
			} );
		} );

		this.pages = pages;
	},

	getHeaderView: function() {
		return this.getChildView( 'header' );
	},

	getCurrentPageName: function() {
		return this.currentPageName;
	},

	getCurrentPageView: function() {
		return this.getChildView( 'content' );
	},

	setPage: function( page, title, viewOptions ) {
		var pageData = this.pages[ page ];

		if ( ! pageData ) {
			throw new ReferenceError( 'Wroter panel doesn\'t have page named \'' + page + '\'' );
		}

		this.showChildView( 'content', new pageData.view( viewOptions ) );

		this.getHeaderView().setTitle( title || pageData.title );

		this.currentPageName = page;
	},

	onBeforeShow: function() {
		var PanelFooterItemView = require( 'wroter-layouts/panel/footer' ),
			PanelHeaderItemView = require( 'wroter-layouts/panel/header' );

		// Edit Mode
		this.showChildView( 'modeSwitcher', new EditModeItemView() );

		// Header
		this.showChildView( 'header', new PanelHeaderItemView() );

		// Footer
		this.showChildView( 'footer', new PanelFooterItemView() );

		// Added Editor events
		this.updateScrollbar = _.throttle( this.updateScrollbar, 100 );

		this.getRegion( 'content' )
			.on( 'before:show', _.bind( this.onEditorBeforeShow, this ) )
			.on( 'empty', _.bind( this.onEditorEmpty, this ) )
			.on( 'show', _.bind( this.updateScrollbar, this ) );

		// Set default page to elements
		this.setPage( 'elements' );

		this.listenTo( wroter.channels.data, 'scrollbar:update', this.updateScrollbar );
	},

	onEditorBeforeShow: function() {
		_.defer( _.bind( this.updateScrollbar, this ) );
	},

	onEditorEmpty: function() {
		this.updateScrollbar();
	},

	updateScrollbar: function() {
		var $panel = this.content.$el;

		if ( ! this._isScrollbarInitialized ) {
			$panel.perfectScrollbar();
			this._isScrollbarInitialized = true;

			return;
		}

		$panel.perfectScrollbar( 'update' );
	}
} );

module.exports = PanelLayoutView;
