var TemplateLibraryHeaderView;

TemplateLibraryHeaderView = Marionette.LayoutView.extend( {

	id: 'wroter-template-library-header',

	template: '#tmpl-wroter-template-library-header',

	regions: {
		logoArea: '#wroter-template-library-header-logo-area',
		tools: '#wroter-template-library-header-tools',
		menuArea: '#wroter-template-library-header-menu-area'
	},

	ui: {
		closeModal: '#wroter-template-library-header-close-modal'
	},

	events: {
		'click @ui.closeModal': 'onCloseModalClick'
	},

	onCloseModalClick: function() {
		wroter.templates.getModal().hide();
	}
} );

module.exports = TemplateLibraryHeaderView;
