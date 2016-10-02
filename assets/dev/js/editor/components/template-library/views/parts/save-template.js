var TemplateLibrarySaveTemplateView;

TemplateLibrarySaveTemplateView = Marionette.ItemView.extend( {
	id: 'wroter-template-library-save-template',

	template: '#tmpl-wroter-template-library-save-template',

	ui: {
		form: '#wroter-template-library-save-template-form',
		submitButton: '#wroter-template-library-save-template-submit'
	},

	events: {
		'submit @ui.form': 'onFormSubmit'
	},

	templateHelpers: function() {
		return {
			sectionID: this.getOption( 'sectionID' )
		};
	},

	onFormSubmit: function( event ) {
		event.preventDefault();

		var formData = this.ui.form.wroterSerializeObject(),
			elementsData = wroter.helpers.cloneObject( wroter.elements.toJSON() ),
			sectionID = this.getOption( 'sectionID' ),
			saveType = sectionID ? 'section' : 'page';

		if ( 'section' === saveType ) {
			elementsData = [ _.findWhere( elementsData, { id: sectionID } ) ];
		}

		_.extend( formData, {
			data: JSON.stringify( elementsData ),
			source: 'local',
			type: saveType
		} );

		this.ui.submitButton.addClass( 'wroter-button-state' );

		wroter.ajax.send( 'save_template', {
			data: formData,
			success: function( data ) {
				wroter.templates.getTemplatesCollection().add( data );

				wroter.templates.setTemplatesSource( 'local' );

				wroter.templates.showTemplates();
			},
			error: function( data ) {
				wroter.templates.showErrorDialog( data.message );
			}
		} );
	}
} );

module.exports = TemplateLibrarySaveTemplateView;
