var TemplateLibraryImportView;

TemplateLibraryImportView = Marionette.ItemView.extend( {
	template: '#tmpl-wroter-template-library-import',

	id: 'wroter-template-library-import',

	ui: {
		uploadForm: '#wroter-template-library-import-form'
	},

	events: {
		'submit @ui.uploadForm': 'onFormSubmit'
	},

	onFormSubmit: function( event ) {
		event.preventDefault();

		wroter.templates.getLayout().showLoadingView();

		wroter.ajax.send( 'import_template', {
			data: new FormData( this.ui.uploadForm[ 0 ] ),
			processData: false,
			contentType: false,
			success: function( data ) {
				wroter.templates.getTemplatesCollection().add( data.item );

				wroter.templates.showTemplates();
			},
			error: function( data ) {
				wroter.templates.showErrorDialog( data.message );
			}
		} );
	}
} );

module.exports = TemplateLibraryImportView;
