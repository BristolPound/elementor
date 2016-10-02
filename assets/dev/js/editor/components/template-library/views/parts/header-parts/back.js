var TemplateLibraryHeaderBackView;

TemplateLibraryHeaderBackView = Marionette.ItemView.extend( {
	template: '#tmpl-wroter-template-library-header-back',

	id: 'wroter-template-library-header-preview-back',

	events: {
		'click': 'onClick'
	},

	onClick: function() {
		wroter.templates.showTemplates();
	}
} );

module.exports = TemplateLibraryHeaderBackView;
