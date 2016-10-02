var TemplateLibraryTemplateView;

TemplateLibraryTemplateView = Marionette.ItemView.extend( {
	className: function() {
		return 'wroter-template-library-template wroter-template-library-template-' + this.model.get( 'source' );
	},

	ui: function() {
		return {
			insertButton: '.wroter-template-library-template-insert',
			previewButton: '.wroter-template-library-template-preview'
		};
	},

	events: function() {
		return {
			'click @ui.insertButton': 'onInsertButtonClick',
			'click @ui.previewButton': 'onPreviewButtonClick'
		};
	},

	onInsertButtonClick: function() {
		wroter.templates.importTemplate( this.model );
	}
} );

module.exports = TemplateLibraryTemplateView;
