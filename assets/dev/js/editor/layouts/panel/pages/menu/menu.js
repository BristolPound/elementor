var PanelMenuItemView = require( 'wroter-panel/pages/menu/views/item' ),
	PanelMenuPageView;

PanelMenuPageView = Marionette.CollectionView.extend( {
	id: 'wroter-panel-page-menu',

	childView: PanelMenuItemView,

	initialize: function() {
		this.collection = new Backbone.Collection( [
            {
                icon: 'paint-brush',
                title: wroter.translate( 'global_colors' ),
				type: 'page',
                pageName: 'colorScheme'
            },
            {
                icon: 'font',
                title: wroter.translate( 'global_fonts' ),
				type: 'page',
                pageName: 'typographyScheme'
            },
            {
				icon: 'file-text',
				title: wroter.translate( 'page_settings' ) + '  <span>(' + wroter.translate( 'soon' ) + ')</span>'
			},
			{
				icon: 'cog',
				title: wroter.translate( 'wroter_settings' ),
				type: 'link',
				link: wroter.config.settings_page_link,
				newTab: true
			},
			{
				icon: 'history',
				title: wroter.translate( 'revisions_history' ) + '  <span>(' + wroter.translate( 'soon' ) + ')</span>'
			},
			{
				icon: 'info-circle',
				title: wroter.translate( 'about_wroter' ),
				type: 'link',
				link: wroter.config.wroter_site,
				newTab: true
			}
		] );
	},

	onChildviewClick: function( childView ) {
		var menuItemType = childView.model.get( 'type' );

		switch ( menuItemType ) {
			case 'page' :
				var pageName = childView.model.get( 'pageName' ),
					pageTitle = childView.model.get( 'title' );

				wroter.getPanelView().setPage( pageName, pageTitle );
				break;

			case 'link' :
				var link = childView.model.get( 'link' ),
					isNewTab = childView.model.get( 'newTab' );

				if ( isNewTab ) {
					open( link, '_blank' );
				} else {
					location.href = childView.model.get( 'link' );
				}

				break;
		}
	}
} );

module.exports = PanelMenuPageView;
