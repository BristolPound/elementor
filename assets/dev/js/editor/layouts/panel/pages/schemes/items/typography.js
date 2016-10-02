var PanelSchemeItemView = require( 'wroter-panel/pages/schemes/items/base' ),
	PanelSchemeTypographyView;

PanelSchemeTypographyView = PanelSchemeItemView.extend( {
	className: function() {
		var classes = PanelSchemeItemView.prototype.className.apply( this, arguments );

		return classes + ' wroter-panel-box';
	},

	ui: {
		heading: '.wroter-panel-heading',
		allFields: '.wroter-panel-scheme-typography-item-field',
		inputFields: 'input.wroter-panel-scheme-typography-item-field',
		selectFields: 'select.wroter-panel-scheme-typography-item-field',
		selectFamilyFields: 'select.wroter-panel-scheme-typography-item-field[name="font_family"]'
	},

	events: {
		'input @ui.inputFields': 'onFieldChange',
		'change @ui.selectFields': 'onFieldChange',
		'click @ui.heading': 'toggleVisibility'
	},

	onRender: function() {
		var self = this;

		this.ui.inputFields.add( this.ui.selectFields ).each( function() {
			var $this = Backbone.$( this ),
				name = $this.attr( 'name' ),
				value = self.model.get( 'value' )[ name ];

			$this.val( value );
		} );

		this.ui.selectFamilyFields.select2( {
			dir: wroter.config.is_rtl ? 'rtl' : 'ltr'
		} );
	},

	toggleVisibility: function() {
		this.ui.heading.toggleClass( 'wroter-open' );
	},

	changeUIValue: function( newValue ) {
		this.ui.allFields.each( function() {
			var $this = Backbone.$( this ),
				thisName = $this.attr( 'name' ),
				newFieldValue = newValue[ thisName ];

			$this.val( newFieldValue ).trigger( 'change' );
		} );
	},

	onFieldChange: function( event ) {
		var $select = this.$( event.currentTarget ),
			currentValue = wroter.helpers.cloneObject( this.model.get( 'value' ) ),
			fieldKey = $select.attr( 'name' );

		currentValue[ fieldKey ] = $select.val();

		if ( 'font_family' === fieldKey && ! _.isEmpty( currentValue[ fieldKey ] ) ) {
			wroter.helpers.enqueueFont( currentValue[ fieldKey ] );
		}

		this.triggerMethod( 'value:change', currentValue );
	}
} );

module.exports = PanelSchemeTypographyView;
