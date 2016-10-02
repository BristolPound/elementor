var TemplateLibraryTemplateLocalView = require( 'wroter-templates/views/template/local' ),
	TemplateLibraryTemplateRemoteView = require( 'wroter-templates/views/template/remote' ),
	TemplateLibraryTemplatesEmptyView = require( 'wroter-templates/views/parts/templates-empty' ),
	TemplateLibraryCollectionView;

TemplateLibraryCollectionView = Marionette.CompositeView.extend( {
	template: '#tmpl-wroter-template-library-templates',

	id: 'wroter-template-library-templates',

	childViewContainer: '#wroter-template-library-templates-container',

	emptyView: TemplateLibraryTemplatesEmptyView,

	getChildView: function( childModel ) {
		if ( 'remote' === childModel.get( 'source' ) ) {
			return TemplateLibraryTemplateRemoteView;
		}

		return TemplateLibraryTemplateLocalView;
	},

	initialize: function() {
		this.listenTo( wroter.channels.templates, 'filter:change', this._renderChildren );
	},

	filterByName: function( model ) {
		var filterValue = wroter.channels.templates.request( 'filter:text' );

		if ( ! filterValue ) {
			return true;
		}

		filterValue = filterValue.toLowerCase();

		if ( model.get( 'title' ).toLowerCase().indexOf( filterValue ) >= 0 ) {
			return true;
		}

		return _.any( model.get( 'keywords' ), function( keyword ) {
			return keyword.toLowerCase().indexOf( filterValue ) >= 0;
		} );
	},

	filterBySource: function( model ) {
		var filterValue = wroter.channels.templates.request( 'filter:source' );

		if ( ! filterValue ) {
			return true;
		}

		return filterValue === model.get( 'source' );
	},

	filter: function( childModel ) {
		return this.filterByName( childModel ) && this.filterBySource( childModel );
	},

	onRenderCollection: function() {
		var isEmpty = this.children.isEmpty();

		this.$childViewContainer.attr( 'data-template-source', isEmpty ? 'empty' : wroter.channels.templates.request( 'filter:source' ) );
	}
} );

module.exports = TemplateLibraryCollectionView;
