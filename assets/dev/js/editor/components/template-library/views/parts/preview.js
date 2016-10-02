var TemplateLibraryPreviewView;

TemplateLibraryPreviewView = Marionette.ItemView.extend( {
	template: '#tmpl-wroter-template-library-preview',

	id: 'wroter-template-library-preview',

	ui: {
		iframe: '> iframe'
	},

	onRender: function() {
		this.ui.iframe.attr( 'src', this.getOption( 'url' ) );
	}
} );

module.exports = TemplateLibraryPreviewView;
