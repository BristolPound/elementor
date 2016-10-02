var TemplateLibraryHeaderLogoView;

TemplateLibraryHeaderLogoView = Marionette.ItemView.extend( {
	template: '#tmpl-wroter-template-library-header-logo',

	id: 'wroter-template-library-header-logo',

	events: {
		'click': 'onClick'
	},

	onClick: function() {
		wroter.templates.setTemplatesSource( 'remote' );
		wroter.templates.showTemplates();
	}
} );

module.exports = TemplateLibraryHeaderLogoView;
