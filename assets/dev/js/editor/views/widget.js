var BaseElementView = require( 'wroter-views/base-element' ),
	WidgetView;

WidgetView = BaseElementView.extend( {
	_templateType: null,

	getTemplate: function() {
		if ( 'remote' !== this.getTemplateType() ) {
			return Marionette.TemplateCache.get( '#tmpl-wroter-widget-' + this.model.get( 'widgetType' ) + '-content' );
		} else {
			return _.template( '' );
		}
	},

	className: function() {
		return 'wroter-widget wroter-widget-' + this.model.get( 'widgetType' );
	},

	modelEvents: {
		'before:remote:render': 'onModelBeforeRemoteRender',
		'remote:render': 'onModelRemoteRender'
	},

	triggers: {
		'click': {
			event: 'click:edit',
			stopPropagation: false
		},
		'click > .wroter-editor-element-settings .wroter-editor-add-element': 'click:add',
		'click > .wroter-editor-element-settings .wroter-editor-element-duplicate': 'click:duplicate'
	},

	elementEvents: {
		'click > .wroter-editor-element-settings .wroter-editor-element-remove': 'onClickRemove'
	},

	behaviors: {
		HandleEditor: {
			behaviorClass: require( 'wroter-behaviors/handle-editor' )
		},
		HandleEditMode: {
			behaviorClass: require( 'wroter-behaviors/handle-edit-mode' )
		}
	},

	initialize: function() {
		BaseElementView.prototype.initialize.apply( this, arguments );

		if ( ! this.model.getHtmlCache() ) {
			this.model.renderRemoteServer();
		}
	},

	getTemplateType: function() {
		if ( null === this.getOption( '_templateType' ) ) {
			var $template = Backbone.$( '#tmpl-wroter-widget-' + this.model.get( 'widgetType' ) + '-content' );

			if ( 0 === $template.length ) {
				this._templateType = 'remote';
			} else {
				this._templateType = 'js';
			}
		}

		return this.getOption( '_templateType' );
	},

	onModelBeforeRemoteRender: function() {
		this.$el.addClass( 'wroter-loading' );
	},

	onBeforeDestroy: function() {
		// Remove old style from the DOM.
		wroter.$previewContents.find( '#wroter-style-' + this.model.cid ).remove();
	},

	onModelRemoteRender: function() {
		if ( this.isDestroyed ) {
			return;
		}

		this.$el.removeClass( 'wroter-loading' );
		this.render();
	},

	attachElContent: function( html ) {
		var htmlCache = this.model.getHtmlCache();

		if ( htmlCache ) {
			html = htmlCache;
		}

		//this.$el.html( html );
		_.defer( _.bind( function() {
			wroterFrontend.getScopeWindow().jQuery( '#' + this.getElementUniqueClass() ).html( html );
		}, this ) );

		return this;
	},

	onRender: function() {
		this.$el
			.removeClass( 'wroter-widget-empty' )
			.children( '.wroter-widget-empty-icon' )
			.remove();

		this.$el.imagesLoaded().always( _.defer( _.bind( function() {
			// Is element empty?
			if ( 1 > this.$el.height() ) {
				this.$el.addClass( 'wroter-widget-empty' );

				// TODO: REMOVE THIS !!
				// TEMP CODING !!
				this.$el.append( '<i class="wroter-widget-empty-icon eicon-' + this.model.getIcon() + '"></i>' );
			}
		}, this ) ) );
	}
} );

module.exports = WidgetView;
