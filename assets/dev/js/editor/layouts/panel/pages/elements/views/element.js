var PanelElementsElementView;

PanelElementsElementView = Marionette.ItemView.extend( {
	template: '#tmpl-wroter-element-library-element',

	className: 'wroter-element-wrapper',

	onRender: function() {
		var self = this;

		this.$el.html5Draggable( {

			onDragStart: function() {
				wroter.channels.panelElements
					.reply( 'element:selected', self )
					.trigger( 'element:drag:start' );
			},

			onDragEnd: function() {
				wroter.channels.panelElements.trigger( 'element:drag:end' );
			},

			groups: [ 'wroter-element' ]
		} );
	}
} );

module.exports = PanelElementsElementView;
