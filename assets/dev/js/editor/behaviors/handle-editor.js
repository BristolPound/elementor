var HandleEditorBehavior;

HandleEditorBehavior = Marionette.Behavior.extend( {

	onClickEdit: function() {
		var activeMode = wroter.channels.dataEditMode.request( 'activeMode' );

		if ( 'preview' === activeMode ) {
			return;
		}

		this.onOpenEditor();
	},

	onOpenEditor: function() {
		var currentPanelPageName = wroter.getPanelView().getCurrentPageName();

		if ( 'editor' === currentPanelPageName ) {
			var currentPanelPageView = wroter.getPanelView().getCurrentPageView(),
				currentEditableModel = currentPanelPageView.model;

			if ( currentEditableModel === this.view.model ) {
				return;
			}
		}

		var elementData = wroter.getElementData( this.view.model );

		wroter.getPanelView().setPage( 'editor', wroter.translate( 'edit_element', [ elementData.title ] ), {
			model: this.view.model,
			editedElementView: this.view
		} );
	}
} );

module.exports = HandleEditorBehavior;
