var RepeaterRowView;

RepeaterRowView = Marionette.CompositeView.extend( {
	template: Marionette.TemplateCache.get( '#tmpl-wroter-repeater-row' ),

	className: 'repeater-fields',

	ui: {
		duplicateButton: '.wroter-repeater-tool-duplicate',
		editButton: '.wroter-repeater-tool-edit',
		removeButton: '.wroter-repeater-tool-remove',
		itemTitle: '.wroter-repeater-row-item-title'
	},

	triggers: {
		'click @ui.removeButton': 'click:remove',
		'click @ui.duplicateButton': 'click:duplicate',
		'click @ui.itemTitle': 'click:edit'
	},

	templateHelpers: function() {
		return {
			itemIndex: this.getOption( 'itemIndex' )
		};
	},

	childViewContainer: '.wroter-repeater-row-controls',

	getChildView: function( item ) {
		var controlType = item.get( 'type' );
		return wroter.getControlItemView( controlType );
	},

	childViewOptions: function() {
		return {
			elementSettingsModel: this.model
		};
	},

	updateIndex: function( newIndex ) {
		this.itemIndex = newIndex;
		this.setTitle();
	},

	setTitle: function() {
		var titleField = this.getOption( 'titleField' ),
			title;

		if ( titleField ) {
			var changerControlModel = this.collection.find( { name: titleField } ),
				changerControlView = this.children.findByModelCid( changerControlModel.cid );

			title = changerControlView.getFieldTitleValue();
		}

		if ( ! title ) {
			title = wroter.translate( 'Item #{0}', [ this.getOption( 'itemIndex' ) ] );
		}

		this.ui.itemTitle.text( title );
	},

	initialize: function( options ) {
		this.elementSettingsModel = options.elementSettingsModel;

		this.itemIndex = 0;

		// Collection for Controls list
		this.collection = new Backbone.Collection( options.controlFields );

		if ( options.titleField ) {
			this.listenTo( this.model, 'change:' + options.titleField, this.setTitle );
		}
	},

	onRender: function() {
		this.setTitle();
	}
} );

module.exports = RepeaterRowView;
