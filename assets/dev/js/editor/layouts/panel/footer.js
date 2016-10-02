var PanelFooterItemView;

PanelFooterItemView = Marionette.ItemView.extend( {
	template: '#tmpl-wroter-panel-footer-content',

	tagName: 'nav',

	id: 'wroter-panel-footer-tools',

	possibleRotateModes: [ 'portrait', 'landscape' ],

	ui: {
		menuButtons: '.wroter-panel-footer-tool',
		deviceModeIcon: '#wroter-panel-footer-responsive > i',
		deviceModeButtons: '#wroter-panel-footer-responsive .wroter-panel-footer-sub-menu-item',
		buttonSave: '#wroter-panel-footer-save',
		buttonSaveButton: '#wroter-panel-footer-save .wroter-button',
		buttonPublish: '#wroter-panel-footer-publish',
		watchTutorial: '#wroter-panel-footer-watch-tutorial',
		showTemplates: '#wroter-panel-footer-templates-modal',
		saveTemplate: '#wroter-panel-footer-save-template'
	},

	events: {
		'click @ui.deviceModeButtons': 'onClickResponsiveButtons',
		'click @ui.buttonSave': 'onClickButtonSave',
		'click @ui.buttonPublish': 'onClickButtonPublish',
		'click @ui.watchTutorial': 'onClickWatchTutorial',
		'click @ui.showTemplates': 'onClickShowTemplates',
		'click @ui.saveTemplate': 'onClickSaveTemplate'
	},

	initialize: function() {
		this._initDialog();

		this.listenTo( wroter.channels.editor, 'editor:changed', this.onEditorChanged )
			.listenTo( wroter.channels.deviceMode, 'change', this.onDeviceModeChange );
	},

	_initDialog: function() {
		var dialog;

		this.getDialog = function() {
			if ( ! dialog ) {
				var $ = Backbone.$,
					$dialogMessage = $( '<div>', {
						'class': 'wroter-dialog-message'
					} ),
					$messageIcon = $( '<i>', {
						'class': 'fa fa-check-circle'
					} ),
					$messageText = $( '<div>', {
						'class': 'wroter-dialog-message-text'
					} ).text( wroter.translate( 'saved' ) );

				$dialogMessage.append( $messageIcon, $messageText );

				dialog = wroter.dialogsManager.createWidget( 'popup', {
					hide: {
						delay: 1500
					}
				} );

				dialog.setMessage( $dialogMessage );
			}

			return dialog;
		};
	},

	_publishBuilder: function() {
		var self = this;

		var options = {
			revision: 'publish',
			onSuccess: function() {
				self.getDialog().show();

				self.ui.buttonSaveButton.removeClass( 'wroter-button-state' );
			}
		};

		self.ui.buttonSaveButton.addClass( 'wroter-button-state' );

		wroter.saveBuilder( options );
	},

	_saveBuilderDraft: function() {
		wroter.saveBuilder();
	},

	getDeviceModeButton: function( deviceMode ) {
		return this.ui.deviceModeButtons.filter( '[data-device-mode="' + deviceMode + '"]' );
	},

	onPanelClick: function( event ) {
		var $target = Backbone.$( event.target ),
			isClickInsideOfTool = $target.closest( '.wroter-panel-footer-sub-menu-wrapper' ).length;

		if ( isClickInsideOfTool ) {
			return;
		}

		var $tool = $target.closest( '.wroter-panel-footer-tool' ),
			isClosedTool = $tool.length && ! $tool.hasClass( 'wroter-open' );

		this.ui.menuButtons.removeClass( 'wroter-open' );

		if ( isClosedTool ) {
			$tool.addClass( 'wroter-open' );
		}
	},

	onEditorChanged: function() {
		this.ui.buttonSave.toggleClass( 'wroter-save-active', wroter.isEditorChanged() );
	},

	onDeviceModeChange: function() {
		var previousDeviceMode = wroter.channels.deviceMode.request( 'previousMode' ),
			currentDeviceMode = wroter.channels.deviceMode.request( 'currentMode' );

		this.getDeviceModeButton( previousDeviceMode ).removeClass( 'active' );

		this.getDeviceModeButton( currentDeviceMode ).addClass( 'active' );

		// Change the footer icon
		this.ui.deviceModeIcon.removeClass( 'eicon-device-' + previousDeviceMode ).addClass( 'eicon-device-' + currentDeviceMode );
	},

	onClickButtonSave: function() {
		//this._saveBuilderDraft();
		this._publishBuilder();
	},

	onClickButtonPublish: function( event ) {
		// Prevent click on save button
		event.stopPropagation();

		this._publishBuilder();
	},

	onClickResponsiveButtons: function( event ) {
		var $clickedButton = this.$( event.currentTarget ),
			newDeviceMode = $clickedButton.data( 'device-mode' );

		wroter.changeDeviceMode( newDeviceMode );
	},

	onClickWatchTutorial: function() {
		wroter.introduction.startIntroduction();
	},

	onClickShowTemplates: function() {
		wroter.templates.startModal( function() {
			wroter.templates.showTemplates();
		} );
	},

	onClickSaveTemplate: function() {
		wroter.templates.startModal( function() {
			wroter.templates.getLayout().showSaveTemplateView();
		} );
	},

	onRender: function() {
		var self = this;

		_.defer( function() {
			wroter.getPanelView().$el.on( 'click', _.bind( self.onPanelClick, self ) );
		} );
	}
} );

module.exports = PanelFooterItemView;
