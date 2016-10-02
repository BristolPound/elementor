var EditModeItemView;

EditModeItemView = Marionette.ItemView.extend( {
	template: '#tmpl-wroter-mode-switcher-content',

	id: 'wroter-mode-switcher-inner',

	ui: {
		previewButton: '#wroter-mode-switcher-preview-input',
		previewLabel: '#wroter-mode-switcher-preview',
		previewLabelA11y: '#wroter-mode-switcher-preview .wroter-screen-only'
	},

	events: {
		'change @ui.previewButton': 'onEditModeChange'
	},

	getCurrentMode: function() {
		return this.ui.previewButton.is( ':checked' ) ? 'preview' : 'edit';
	},

	setMode: function( mode ) {
		this.ui.previewButton.prop( 'checked', 'preview' === mode );
	},

	onRender: function() {
		this.onEditModeChange();
	},

	onEditModeChange: function() {
		var dataEditMode = wroter.channels.dataEditMode,
			oldEditMode = dataEditMode.request( 'activeMode' ),
			currentMode = this.getCurrentMode();

		dataEditMode.reply( 'activeMode', currentMode );

		if ( currentMode !== oldEditMode ) {
			dataEditMode.trigger( 'switch' );

			var title = 'preview' === currentMode ? 'Back to Editor' : 'Preview';

			this.ui.previewLabel.attr( 'title', title );
			this.ui.previewLabelA11y.text( title );
		}
	}
} );

module.exports = EditModeItemView;
