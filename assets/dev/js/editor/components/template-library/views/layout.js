var TemplateLibraryHeaderView = require( 'wroter-templates/views/parts/header' ),
	TemplateLibraryHeaderLogoView = require( 'wroter-templates/views/parts/header-parts/logo' ),
	TemplateLibraryHeaderSaveView = require( 'wroter-templates/views/parts/header-parts/save' ),
	TemplateLibraryHeaderMenuView = require( 'wroter-templates/views/parts/header-parts/menu' ),
	TemplateLibraryHeaderPreviewView = require( 'wroter-templates/views/parts/header-parts/preview' ),
	TemplateLibraryHeaderBackView = require( 'wroter-templates/views/parts/header-parts/back' ),
	TemplateLibraryLoadingView = require( 'wroter-templates/views/parts/loading' ),
	TemplateLibraryCollectionView = require( 'wroter-templates/views/parts/templates' ),
	TemplateLibrarySaveTemplateView = require( 'wroter-templates/views/parts/save-template' ),
	TemplateLibraryImportView = require( 'wroter-templates/views/parts/import' ),
	TemplateLibraryPreviewView = require( 'wroter-templates/views/parts/preview' ),
	TemplateLibraryLayoutView;

TemplateLibraryLayoutView = Marionette.LayoutView.extend( {
	el: '#wroter-template-library-modal',

	regions: {
		modalContent: '.dialog-message',
		modalHeader: '.dialog-widget-header'
	},

	initialize: function() {
		this.getRegion( 'modalHeader' ).show( new TemplateLibraryHeaderView() );
	},

	getHeaderView: function() {
		return this.getRegion( 'modalHeader' ).currentView;
	},

	showLoadingView: function() {
		this.getRegion( 'modalContent' ).show( new TemplateLibraryLoadingView() );
	},

	showTemplatesView: function( templatesCollection ) {
		this.getRegion( 'modalContent' ).show( new TemplateLibraryCollectionView( {
			collection: templatesCollection
		} ) );

		var headerView = this.getHeaderView();

		headerView.tools.show( new TemplateLibraryHeaderSaveView() );
		headerView.menuArea.show( new TemplateLibraryHeaderMenuView() );
		headerView.logoArea.show( new TemplateLibraryHeaderLogoView() );
	},

	showImportView: function() {
		this.getRegion( 'modalContent' ).show( new TemplateLibraryImportView() );
	},

	showSaveTemplateView: function( sectionID ) {
		this.getRegion( 'modalContent' ).show( new TemplateLibrarySaveTemplateView( { sectionID: sectionID } ) );

		var headerView = this.getHeaderView();

		headerView.tools.reset();
		headerView.menuArea.reset();
		headerView.logoArea.show( new TemplateLibraryHeaderLogoView() );
	},

	showPreviewView: function( templateModel ) {
		this.getRegion( 'modalContent' ).show( new TemplateLibraryPreviewView( {
			url: templateModel.get( 'url' )
		} ) );

		var headerView = this.getHeaderView();

		headerView.menuArea.reset();

		headerView.tools.show( new TemplateLibraryHeaderPreviewView( {
			model: templateModel
		} ) );

		headerView.logoArea.show( new TemplateLibraryHeaderBackView() );
	}
} );

module.exports = TemplateLibraryLayoutView;
