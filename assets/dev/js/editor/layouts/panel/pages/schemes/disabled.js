var PanelSchemeDisabledView;

PanelSchemeDisabledView = Marionette.ItemView.extend( {
	template: '#tmpl-wroter-panel-schemes-disabled',

	disabledTitle: '',

	templateHelpers: function() {
		return {
			disabledTitle: this.disabledTitle
		};
	},

	id: 'wroter-panel-schemes-disabled'
} );

module.exports = PanelSchemeDisabledView;
