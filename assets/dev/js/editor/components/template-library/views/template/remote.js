var TemplateLibraryTemplateView = require( 'wroter-templates/views/template/base' ),
	TemplateLibraryTemplateRemoteView;

TemplateLibraryTemplateRemoteView = TemplateLibraryTemplateView.extend( {
	template: '#tmpl-wroter-template-library-template-remote',

	onPreviewButtonClick: function() {
		wroter.templates.getLayout().showPreviewView( this.model );
	}
} );

module.exports = TemplateLibraryTemplateRemoteView;
