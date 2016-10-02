var PanelElementsElementView = require( './element' ),
	PanelElementsElementsView;

PanelElementsElementsView = Marionette.CollectionView.extend( {
	childView: PanelElementsElementView,

	id: 'wroter-panel-elements',

	initialize: function() {
		this.listenTo( wroter.channels.panelElements, 'change', this.onFilterChanged );
	},

	filter: function( childModel ) {
		var filterValue = wroter.channels.panelElements.request( 'filter:value' );

		if ( ! filterValue ) {
			return true;
		}

		return _.any( [ 'title', 'keywords' ], function( type ) {
			return ( -1 !== childModel.get( type ).toLowerCase().indexOf( filterValue.toLowerCase() ) );
		} );
	},

	onFilterChanged: function() {
		this._renderChildren();
		this.triggerMethod( 'children:render' );
	}
} );

module.exports = PanelElementsElementsView;
