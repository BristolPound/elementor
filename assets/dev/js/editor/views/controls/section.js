var ControlBaseItemView = require( 'wroter-views/controls/base' ),
	ControlSectionItemView;

ControlSectionItemView = ControlBaseItemView.extend( {
	ui: function() {
		var ui = ControlBaseItemView.prototype.ui.apply( this, arguments );

		ui.heading = '.wroter-panel-heading';

		return ui;
	},

	triggers: {
		'click': 'control:section:clicked'
	}
} );

module.exports = ControlSectionItemView;
