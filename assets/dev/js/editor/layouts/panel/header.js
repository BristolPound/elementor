var PanelHeaderItemView;

PanelHeaderItemView = Marionette.ItemView.extend( {
	template: '#tmpl-wroter-panel-header',

	id: 'wroter-panel-header',

	ui: {
		menuButton: '#wroter-panel-header-menu-button',
		title: '#wroter-panel-header-title',
		addButton: '#wroter-panel-header-add-button'
	},

	events: {
		'click @ui.addButton': 'onClickAdd',
		'click @ui.menuButton': 'onClickMenu'
	},

	setTitle: function( title ) {
		this.ui.title.html( title );
	},

	onClickAdd: function() {
		wroter.getPanelView().setPage( 'elements' );
	},

	onClickMenu: function() {
		var panel = wroter.getPanelView(),
			currentPanelPageName = panel.getCurrentPageName(),
			nextPage = 'menu' === currentPanelPageName ? 'elements' : 'menu';

		panel.setPage( nextPage );
	}
} );

module.exports = PanelHeaderItemView;
