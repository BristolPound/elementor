var HandleEditModeBehavior;

HandleEditModeBehavior = Marionette.Behavior.extend( {
	initialize: function() {
		this.listenTo( wroter.channels.dataEditMode, 'switch', this.onEditModeSwitched );
	},

	onEditModeSwitched: function() {
		var activeMode = wroter.channels.dataEditMode.request( 'activeMode' );

		this.view.$el.toggleClass( 'wroter-active-mode', 'preview' !== activeMode );
	},

	onRender: function() {
		this.onEditModeSwitched();
	}
} );

module.exports = HandleEditModeBehavior;
