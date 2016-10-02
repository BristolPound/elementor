var TemplateLibraryHeaderPreviewView;

TemplateLibraryHeaderPreviewView = Marionette.ItemView.extend( {
	template: '#tmpl-wroter-template-library-header-preview',

	id: 'wroter-template-library-header-preview',

	ui: {
		insertButton: '#wroter-template-library-header-preview-insert'
	},

	events: {
		'click @ui.insertButton': 'onInsertButtonClick'
	},

	onInsertButtonClick: function() {
		wroter.templates.importTemplate( this.model );
	}
} );

module.exports = TemplateLibraryHeaderPreviewView;
