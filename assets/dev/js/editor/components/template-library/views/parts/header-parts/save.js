var TemplateLibraryHeaderSaveView;

TemplateLibraryHeaderSaveView = Marionette.ItemView.extend( {
	template: '#tmpl-wroter-template-library-header-save',

	id: 'wroter-template-library-header-save',

	className: 'wroter-template-library-header-item',

	events: {
		'click': 'onClick'
	},

	onClick: function() {
		wroter.templates.getLayout().showSaveTemplateView();
	}
} );

module.exports = TemplateLibraryHeaderSaveView;
