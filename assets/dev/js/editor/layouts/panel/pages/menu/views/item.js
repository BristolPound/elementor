var PanelMenuItemView;

PanelMenuItemView = Marionette.ItemView.extend( {
	template: '#tmpl-wroter-panel-menu-item',

	className: 'wroter-panel-menu-item',

	triggers: {
		click: 'click'
	}
} );

module.exports = PanelMenuItemView;
