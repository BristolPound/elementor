/* global WroterConfig */
var App;

Marionette.TemplateCache.prototype.compileTemplate = function( rawTemplate, options ) {
	options = {
		evaluate: /<#([\s\S]+?)#>/g,
		interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
		escape: /\{\{([^\}]+?)\}\}(?!\})/g
	};

	return _.template( rawTemplate, options );
};

App = Marionette.Application.extend( {
	helpers: require( 'wroter-utils/helpers' ),
	heartbeat: require( 'wroter-utils/heartbeat' ),
	schemes: require( 'wroter-utils/schemes' ),
	presetsFactory: require( 'wroter-utils/presets-factory' ),
	modals: require( 'wroter-utils/modals' ),
	introduction: require( 'wroter-utils/introduction' ),
	templates: require( 'wroter-templates/manager' ),
	ajax: require( 'wroter-utils/ajax' ),

	channels: {
		editor: Backbone.Radio.channel( 'WROTER:editor' ),
		data: Backbone.Radio.channel( 'WROTER:data' ),
		panelElements: Backbone.Radio.channel( 'WROTER:panelElements' ),
		dataEditMode: Backbone.Radio.channel( 'WROTER:editmode' ),
		deviceMode: Backbone.Radio.channel( 'WROTER:deviceMode' ),
		templates: Backbone.Radio.channel( 'WROTER:templates' )
	},

	// Private Members
	_controlsItemView: null,

	_defaultDeviceMode: 'desktop',

	getElementData: function( modelElement ) {
		var elType = modelElement.get( 'elType' );

		if ( 'widget' === elType ) {
			var widgetType = modelElement.get( 'widgetType' );

			if ( ! this.config.widgets[ widgetType ] ) {
				return false;
			}

			return this.config.widgets[ widgetType ];
		}

		if ( ! this.config.elements[ elType ] ) {
			return false;
		}

		return this.config.elements[ elType ];
	},

	getElementControls: function( modelElement ) {
		var elementData = this.getElementData( modelElement );

		if ( ! elementData ) {
			return false;
		}

		var elType = modelElement.get( 'elType' ),
			isInner = modelElement.get( 'isInner' );

		if ( 'widget' === elType ) {
			return elementData.controls;
		}

		return _.filter( elementData.controls, function( controlData ) {
			return ! ( isInner && controlData.hide_in_inner || ! isInner && controlData.hide_in_top );
		} );
	},

	getControlItemView: function( controlType ) {
		if ( null === this._controlsItemView ) {
			this._controlsItemView = {
				color: require( 'wroter-views/controls/color' ),
				dimensions: require( 'wroter-views/controls/dimensions' ),
				image_dimensions: require( 'wroter-views/controls/image-dimensions' ),
				media: require( 'wroter-views/controls/media' ),
				slider: require( 'wroter-views/controls/slider' ),
				wysiwyg: require( 'wroter-views/controls/wysiwyg' ),
				choose: require( 'wroter-views/controls/choose' ),
				url: require( 'wroter-views/controls/url' ),
				font: require( 'wroter-views/controls/font' ),
				section: require( 'wroter-views/controls/section' ),
				repeater: require( 'wroter-views/controls/repeater' ),
				wp_widget: require( 'wroter-views/controls/wp_widget' ),
				icon: require( 'wroter-views/controls/icon' ),
				gallery: require( 'wroter-views/controls/gallery' ),
				select2: require( 'wroter-views/controls/select2' ),
				box_shadow: require( 'wroter-views/controls/box-shadow' ),
				structure: require( 'wroter-views/controls/structure' ),
				animation: require( 'wroter-views/controls/animation' ),
				hover_animation: require( 'wroter-views/controls/animation' )
			};

			this.channels.editor.trigger( 'editor:controls:initialize' );
		}

		return this._controlsItemView[ controlType ] || require( 'wroter-views/controls/base' );
	},

	getPanelView: function() {
		return this.getRegion( 'panel' ).currentView;
	},

	initComponents: function() {
		this.initDialogsManager();

		this.heartbeat.init();
		this.modals.init();
		this.ajax.init();
	},

	initDialogsManager: function() {
		this.dialogsManager = new DialogsManager.Instance();
	},

	initPreview: function() {
		this.$previewWrapper = Backbone.$( '#wroter-preview' );

		this.$previewResponsiveWrapper = Backbone.$( '#wroter-preview-responsive-wrapper' );

		var previewIframeId = 'wroter-preview-iframe';

		// Make sure the iFrame does not exist.
		if ( ! Backbone.$( '#' + previewIframeId ).length ) {
			var previewIFrame = document.createElement( 'iframe' );

			previewIFrame.id = previewIframeId;
			previewIFrame.src = this.config.preview_link + '&' + ( new Date().getTime() );

			this.$previewResponsiveWrapper.append( previewIFrame );
		}

		this.$preview = Backbone.$( '#' + previewIframeId );

		this.$preview.on( 'load', _.bind( this.onPreviewLoaded, this ) );
	},

	initFrontend: function() {
		wroterFrontend.setScopeWindow( this.$preview[0].contentWindow );

		wroterFrontend.init();
	},

	onStart: function() {
		NProgress.start();
		NProgress.inc( 0.2 );

		this.config = WroterConfig;

		Backbone.Radio.DEBUG = false;
		Backbone.Radio.tuneIn( 'WROTER' );

		this.initComponents();

		// Init Base elements collection from the server
		var ElementModel = require( 'wroter-models/element' );

		this.elements = new ElementModel.Collection( this.config.data );

		this.initPreview();

		this.listenTo( this.channels.dataEditMode, 'switch', this.onEditModeSwitched );

		this.setWorkSaver();
	},

	onPreviewLoaded: function() {
		NProgress.done();

		this.initFrontend();

		this.$previewContents = this.$preview.contents();

		var SectionsCollectionView = require( 'wroter-views/sections' ),
			PanelLayoutView = require( 'wroter-layouts/panel/panel' );

		var $previewWroterEl = this.$previewContents.find( '#wroter' );

		if ( ! $previewWroterEl.length ) {
			this.onPreviewElNotFound();
			return;
		}

		var iframeRegion = new Marionette.Region( {
			// Make sure you get the DOM object out of the jQuery object
			el: $previewWroterEl[0]
		} );

		this.schemes.init();
		this.schemes.printSchemesStyle();

		this.$previewContents.on( 'click', function( event ) {
			var $target = Backbone.$( event.target ),
				editMode = wroter.channels.dataEditMode.request( 'activeMode' ),
				isClickInsideWroter = !! $target.closest( '#wroter' ).length,
				isTargetInsideDocument = this.contains( $target[0] );

			if ( isClickInsideWroter && 'preview' !== editMode || ! isTargetInsideDocument ) {
				return;
			}

			if ( $target.closest( 'a' ).length ) {
				event.preventDefault();
			}

			if ( ! isClickInsideWroter ) {
				wroter.getPanelView().setPage( 'elements' );
			}
		} );

		this.addRegions( {
			sections: iframeRegion,
			panel: '#wroter-panel'
		} );

		this.getRegion( 'sections' ).show( new SectionsCollectionView( {
			collection: this.elements
		} ) );

		this.getRegion( 'panel' ).show( new PanelLayoutView() );

		this.$previewContents
		    .children() // <html>
		    .addClass( 'wroter-html' )
		    .children( 'body' )
		    .addClass( 'wroter-editor-active' );

		this.setResizablePanel();

		this.changeDeviceMode( this._defaultDeviceMode );

		Backbone.$( '#wroter-loading' ).fadeOut( 600 );

		_.defer( function() {
			wroterFrontend.getScopeWindow().jQuery.holdReady( false );
		} );

		this.enqueueTypographyFonts();

		//this.introduction.startOnLoadIntroduction(); // TEMP Removed

		this.trigger( 'preview:loaded' );
	},

	onEditModeSwitched: function() {
		var activeMode = wroter.channels.dataEditMode.request( 'activeMode' );

		if ( 'preview' === activeMode ) {
			this.enterPreviewMode();
		} else {
			this.exitPreviewMode();
		}
	},

	onPreviewElNotFound: function() {
		var dialog = this.dialogsManager.createWidget( 'confirm', {
			id: 'wroter-fatal-error-dialog',
			headerMessage: wroter.translate( 'preview_el_not_found_header' ),
			message: wroter.translate( 'preview_el_not_found_message' ),
			position: {
				my: 'center center',
				at: 'center center'
			},
            strings: {
				confirm: wroter.translate( 'learn_more' ),
				cancel: wroter.translate( 'go_back' )
            },
			onConfirm: function() {
				open( wroter.config.help_the_content_url, '_blank' );
			},
			onCancel: function() {
				parent.history.go( -1 );
			},
			hideOnButtonClick: false
		} );

		dialog.show();
	},

	setFlagEditorChange: function( status ) {
		wroter.channels.editor.reply( 'editor:changed', status );
		wroter.channels.editor.trigger( 'editor:changed', status );
	},

	isEditorChanged: function() {
		return ( true === wroter.channels.editor.request( 'editor:changed' ) );
	},

	setWorkSaver: function() {
		Backbone.$( window ).on( 'beforeunload', function() {
			if ( wroter.isEditorChanged() ) {
				return wroter.translate( 'before_unload_alert' );
			}
		} );
	},

	setResizablePanel: function() {
		var self = this,
			side = wroter.config.is_rtl ? 'right' : 'left';

		self.panel.$el.resizable( {
			handles: wroter.config.is_rtl ? 'w' : 'e',
			minWidth: 200,
			maxWidth: 500,
			start: function() {
				self.$previewWrapper
					.addClass( 'ui-resizable-resizing' )
					.css( 'pointer-events', 'none' );
			},
			stop: function() {
				self.$previewWrapper
					.removeClass( 'ui-resizable-resizing' )
					.css( 'pointer-events', '' );

				wroter.channels.data.trigger( 'scrollbar:update' );
			},
			resize: function( event, ui ) {
				self.$previewWrapper
					.css( side, ui.size.width );
			}
		} );
	},

	enterPreviewMode: function() {
		this.$previewContents
		    .find( 'body' )
		    .add( 'body' )
		    .removeClass( 'wroter-editor-active' )
		    .addClass( 'wroter-editor-preview' );

		// Handle panel resize
		this.$previewWrapper.css( wroter.config.is_rtl ? 'right' : 'left', '' );

		this.panel.$el.css( 'width', '' );
	},

	exitPreviewMode: function() {
		this.$previewContents
		    .find( 'body' )
		    .add( 'body' )
		    .removeClass( 'wroter-editor-preview' )
		    .addClass( 'wroter-editor-active' );
	},

	saveBuilder: function( options ) {
		options = _.extend( {
			revision: 'draft',
			onSuccess: null
		}, options );

		NProgress.start();

		return this.ajax.send( 'save_builder', {
	        data: {
		        post_id: this.config.post_id,
		        revision: options.revision,
		        data: JSON.stringify( wroter.elements.toJSON() )
	        },
			success: function( data ) {
				NProgress.done();

				wroter.setFlagEditorChange( false );

				if ( _.isFunction( options.onSuccess ) ) {
					options.onSuccess.call( this, data );
				}
			}
        } );
	},

	changeDeviceMode: function( newDeviceMode ) {
		var oldDeviceMode = this.channels.deviceMode.request( 'currentMode' );

		if ( oldDeviceMode === newDeviceMode ) {
			return;
		}

		Backbone.$( 'body' )
			.removeClass( 'wroter-device-' + oldDeviceMode )
			.addClass( 'wroter-device-' + newDeviceMode );

		this.channels.deviceMode
			.reply( 'previousMode', oldDeviceMode )
			.reply( 'currentMode', newDeviceMode )
			.trigger( 'change' );
	},

	enqueueTypographyFonts: function() {
		var self = this,
			typographyScheme = this.schemes.getScheme( 'typography' );

		_.each( typographyScheme.items, function( item ) {
			self.helpers.enqueueFont( item.value.font_family );
		} );
	},

	translate: function( stringKey, templateArgs ) {
		var string = this.config.i18n[ stringKey ];

		if ( undefined === string ) {
			string = stringKey;
		}

		if ( templateArgs ) {
			string = string.replace( /{(\d+)}/g, function( match, number ) {
				return undefined !== templateArgs[ number ] ? templateArgs[ number ] : match;
			} );
		}

		return string;
	}
} );

module.exports = ( window.wroter = new App() ).start();
