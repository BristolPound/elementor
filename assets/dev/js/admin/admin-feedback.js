/* global jQuery, WroterAdminFeedbackArgs */
( function( $ ) {
	'use strict';

	var WroterAdminDialogApp = {

		wroterModals: require( 'wroter-utils/modals' ),

		dialogsManager: new DialogsManager.Instance(),

		cacheElements: function() {
			this.cache = {
				$deactivateLink: $( '#the-list' ).find( '[data-slug="wroter"] span.deactivate a' ),
				$dialogHeader: $( '#wroter-deactivate-feedback-dialog-header' ),
				$dialogForm: $( '#wroter-deactivate-feedback-dialog-form' )
			};
		},

		bindEvents: function() {
			var self = this;

			self.cache.$deactivateLink.on( 'click', function( event ) {
				event.preventDefault();

				self.getModal().show();
			} );
		},

		deactivate: function() {
			location.href = this.cache.$deactivateLink.attr( 'href' );
		},

		initModal: function() {
			var self = this,
				modal;

			self.getModal = function() {
				if ( ! modal ) {
					modal = self.dialogsManager.createWidget( 'wroter-modal', {
						id: 'wroter-deactivate-feedback-modal',
						headerMessage: self.cache.$dialogHeader,
						message: self.cache.$dialogForm,
						hideOnButtonClick: false,
						onReady: function() {
							DialogsManager.getWidgetType( 'wroter-modal' ).prototype.onReady.apply( this, arguments );

							this.addButton( {
								name: 'submit',
								text: WroterAdminFeedbackArgs.i18n.submit_n_deactivate,
								callback: _.bind( self.sendFeedback, self )
							} );

							if ( ! WroterAdminFeedbackArgs.is_tracker_opted_in ) {
								this.addButton( {
									name: 'skip',
									text: WroterAdminFeedbackArgs.i18n.skip_n_deactivate,
									callback: function() {
										self.deactivate();
									}
								} );
							}
						}
					} );
				}

				return modal;
			};
		},

		sendFeedback: function() {
			var self = this,
				formData = self.cache.$dialogForm.serialize();

			self.getModal().getElements( 'submit' ).text( '' ).addClass( 'wroter-loading' );

			$.post( ajaxurl, formData, _.bind( this.deactivate, this ) );
		},

		init: function() {
			this.wroterModals.init();
			this.initModal();
			this.cacheElements();
			this.bindEvents();
		}
	};

	$( function() {
		WroterAdminDialogApp.init();
	} );

}( jQuery ) );
