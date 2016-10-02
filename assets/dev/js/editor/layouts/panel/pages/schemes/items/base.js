var PanelSchemeItemView;

PanelSchemeItemView = Marionette.ItemView.extend( {
	getTemplate: function() {
		return Marionette.TemplateCache.get( '#tmpl-wroter-panel-scheme-' + this.model.get( 'type' ) + '-item' );
	},

	className: function() {
		return 'wroter-panel-scheme-item';
	}
} );

module.exports = PanelSchemeItemView;
