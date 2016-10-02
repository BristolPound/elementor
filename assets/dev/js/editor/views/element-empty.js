var ElementEmptyView;

ElementEmptyView = Marionette.ItemView.extend( {
	template: '#tmpl-wroter-empty-preview',

	className: 'wroter-empty-view',

	events: {
		'click': 'onClickAdd'
	},

	onClickAdd: function() {
		wroter.getPanelView().setPage( 'elements' );
	}
} );

module.exports = ElementEmptyView;
