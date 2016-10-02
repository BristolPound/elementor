var TemplateLibraryHeaderMenuView;

TemplateLibraryHeaderMenuView = Marionette.ItemView.extend( {
	options: {
		activeClass: 'wroter-active'
	},

	template: '#tmpl-wroter-template-library-header-menu',

	id: 'wroter-template-library-header-menu',

	ui: {
		menuItems: '.wroter-template-library-menu-item'
	},

	events: {
		'click @ui.menuItems': 'onMenuItemClick'
	},

	$activeItem: null,

	activateMenuItem: function( $item ) {
		var activeClass = this.getOption( 'activeClass' );

		if ( this.$activeItem === $item ) {
			return;
		}

		if ( this.$activeItem ) {
			this.$activeItem.removeClass( activeClass );
		}

		$item.addClass( activeClass );

		this.$activeItem = $item;
	},

	onRender: function() {
		var currentSource = wroter.channels.templates.request( 'filter:source' ),
			$sourceItem = this.ui.menuItems.filter( '[data-template-source="' + currentSource + '"]' );

		this.activateMenuItem( $sourceItem );
	},

	onMenuItemClick: function( event ) {
		var item = event.currentTarget;

		this.activateMenuItem( Backbone.$( item ) );

		wroter.templates.setTemplatesSource( item.dataset.templateSource, true );
	}
} );

module.exports = TemplateLibraryHeaderMenuView;
