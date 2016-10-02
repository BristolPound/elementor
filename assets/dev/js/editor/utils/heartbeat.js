var heartbeat;

heartbeat = {

	init: function() {
		var modal;

		this.getModal = function() {
			if ( ! modal ) {
				modal = this.initModal();
			}

			return modal;
		};

		Backbone.$( document ).on( {
			'heartbeat-send': function( event, data ) {
				data.wroter_post_lock = {
					post_ID: wroter.config.post_id
				};
			},
			'heartbeat-tick': function( event, response ) {
				if ( response.locked_user ) {
					heartbeat.showLockMessage( response.locked_user );
				} else {
					heartbeat.getModal().hide();
				}

				wroter.config.nonce = response.wroter_nonce;
			}
		} );

		if ( wroter.config.locked_user ) {
			heartbeat.showLockMessage( wroter.config.locked_user );
		}
	},

	initModal: function() {
		var modal = wroter.dialogsManager.createWidget( 'options', {
			headerMessage: wroter.translate( 'take_over' )
		} );

		modal.addButton( {
			name: 'go_back',
			text: wroter.translate( 'go_back' ),
			callback: function() {
				parent.history.go( -1 );
			}
		} );

		modal.addButton( {
			name: 'take_over',
			text: wroter.translate( 'take_over' ),
			callback: function() {
				wp.heartbeat.enqueue( 'wroter_force_post_lock', true );
				wp.heartbeat.connectNow();
			}
		} );

		return modal;
	},

	showLockMessage: function( lockedUser ) {
		var modal = heartbeat.getModal();

		modal
			.setMessage( wroter.translate( 'dialog_user_taken_over', [ lockedUser ] ) )
		    .show();
	}
};

module.exports = heartbeat;
