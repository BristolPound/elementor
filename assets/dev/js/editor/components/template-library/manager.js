var TemplateLibraryLayoutView = require( 'wroter-templates/views/layout' ),
	TemplateLibraryCollection = require( 'wroter-templates/collections/templates' ),
	TemplateLibraryManager;

TemplateLibraryManager = function() {
	var self = this,
		modal,
		deleteDialog,
		errorDialog,
		layout,
		templatesCollection;

	var initLayout = function() {
		layout = new TemplateLibraryLayoutView();
	};

	this.deleteTemplate = function( templateModel ) {
		var dialog = self.getDeleteDialog();

		dialog.onConfirm = function() {
			wroter.ajax.send( 'delete_template', {
				data: {
					source: templateModel.get( 'source' ),
					template_id: templateModel.get( 'template_id' )
				},
				success: function() {
					templatesCollection.remove( templateModel, { silent: true } );

					self.showTemplates();
				}
			} );
		};

		dialog.show();
	};

	this.importTemplate = function( templateModel ) {
		layout.showLoadingView();

		wroter.ajax.send( 'get_template_content', {
			data: {
				source: templateModel.get( 'source' ),
				post_id: wroter.config.post_id,
				template_id: templateModel.get( 'template_id' )
			},
			success: function( data ) {
				self.getModal().hide();

				wroter.getRegion( 'sections' ).currentView.addChildModel( data );
			},
			error: function( data ) {
				self.showErrorDialog( data.message );
			}
		} );
	};

	this.getDeleteDialog = function() {
		if ( ! deleteDialog ) {
			deleteDialog = wroter.dialogsManager.createWidget( 'confirm', {
				id: 'wroter-template-library-delete-dialog',
				headerMessage: wroter.translate( 'delete_template' ),
				message: wroter.translate( 'delete_template_confirm' ),
				strings: {
					confirm: wroter.translate( 'delete' )
				}
			} );
		}

		return deleteDialog;
	};

	this.getErrorDialog = function() {
		if ( ! errorDialog ) {
			errorDialog = wroter.dialogsManager.createWidget( 'alert', {
				id: 'wroter-template-library-error-dialog',
				headerMessage: wroter.translate( 'an_error_occurred' )
			} );
		}

		return errorDialog;
	};

	this.getModal = function() {
		if ( ! modal ) {
			modal = wroter.dialogsManager.createWidget( 'wroter-modal', {
				id: 'wroter-template-library-modal',
				closeButton: false
			} );
		}

		return modal;
	};

	this.getLayout = function() {
		return layout;
	};

	this.getTemplatesCollection = function() {
		return templatesCollection;
	};

	this.requestRemoteTemplates = function( callback, forceUpdate ) {
		if ( templatesCollection && ! forceUpdate ) {
			if ( callback ) {
				callback();
			}

			return;
		}

		wroter.ajax.send( 'get_templates', {
			success: function( data ) {
				templatesCollection = new TemplateLibraryCollection( data );

				if ( callback ) {
					callback();
				}
			}
		} );
	};

	this.startModal = function( onModalReady ) {
		self.getModal().show();

		self.setTemplatesSource( 'remote' );

		if ( ! layout ) {
			initLayout();
		}

		layout.showLoadingView();

		self.requestRemoteTemplates( function() {
			if ( onModalReady ) {
				onModalReady();
			}
		} );
	};

	this.setTemplatesSource = function( source, trigger ) {
		var channel = wroter.channels.templates;

		channel.reply( 'filter:source', source );

		if ( trigger ) {
			channel.trigger( 'filter:change' );
		}
	};

	this.showTemplates = function() {
		layout.showTemplatesView( templatesCollection );
	};

	this.showErrorDialog = function( errorMessage ) {
		self.getErrorDialog()
		    .setMessage( wroter.translate( 'templates_request_error' ) + '<div id="wroter-template-library-error-info">' + errorMessage + '</div>' )
		    .show();
	};
};

module.exports = new TemplateLibraryManager();
