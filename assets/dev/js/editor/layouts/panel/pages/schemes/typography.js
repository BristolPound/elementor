var PanelSchemeBaseView = require( 'wroter-panel/pages/schemes/base' ),
	PanelSchemeTypographyView;

PanelSchemeTypographyView = PanelSchemeBaseView.extend( {

	getChildView: function() {
		return require( 'wroter-panel/pages/schemes/items/typography' );
	},

	getType: function() {
		return 'typography';
	}
} );

module.exports = PanelSchemeTypographyView;
