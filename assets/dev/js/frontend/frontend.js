/* global wroterFrontendConfig */
( function( $ ) {
	var ElementsHandler = require( 'wroter-frontend/elements-handler' ),
	    Utils = require( 'wroter-frontend/utils' );

	var WroterFrontend = function() {
		var self = this,
			scopeWindow = window;

		var elementsDefaultHandlers = {
			accordion: require( 'wroter-frontend/handlers/accordion' ),
			alert: require( 'wroter-frontend/handlers/alert' ),
			counter: require( 'wroter-frontend/handlers/counter' ),
			'image-carousel': require( 'wroter-frontend/handlers/image-carousel' ),
			'menu-anchor': require( 'wroter-frontend/handlers/menu-anchor' ),
			progress: require( 'wroter-frontend/handlers/progress' ),
			section: require( 'wroter-frontend/handlers/section' ),
			tabs: require( 'wroter-frontend/handlers/tabs' ),
			toggle: require( 'wroter-frontend/handlers/toggle' ),
			video: require( 'wroter-frontend/handlers/video' )
		};

		var addGlobalHandlers = function() {
			self.elementsHandler.addGlobalHandler( require( 'wroter-frontend/handlers/global' ) );
		};

		var addElementsHandlers = function() {
			$.each( elementsDefaultHandlers, function( elementName ) {
				self.elementsHandler.addHandler( elementName, this );
			} );
		};

		var runElementsHandlers = function() {
			$( '.wroter-element' ).each( function() {
				self.elementsHandler.runReadyTrigger( $( this ) );
			} );
		};

		this.config = wroterFrontendConfig;

		this.getScopeWindow = function() {
			return scopeWindow;
		};

		this.setScopeWindow = function( window ) {
			scopeWindow = window;
		};

		this.isEditMode = function() {
			return self.config.isEditMode;
		};

		this.elementsHandler = new ElementsHandler( $ );

		this.utils = new Utils( $ );

		this.init = function() {
			addGlobalHandlers();

			addElementsHandlers();

			self.utils.insertYTApi();

			runElementsHandlers();
		};

		// Based on underscore function
		this.throttle = function( func, wait ) {
			var timeout,
				context,
				args,
				result,
				previous = 0;

			var later = function() {
				previous = Date.now();
				timeout = null;
				result = func.apply( context, args );

				if ( ! timeout ) {
					context = args = null;
				}
			};

			return function() {
				var now = Date.now(),
					remaining = wait - ( now - previous );

				context = this;
				args = arguments;

				if ( remaining <= 0 || remaining > wait ) {
					if ( timeout ) {
						clearTimeout( timeout );
						timeout = null;
					}

					previous = now;
					result = func.apply( context, args );

					if ( ! timeout ) {
						context = args = null;
					}
				} else if ( ! timeout ) {
					timeout = setTimeout( later, remaining );
				}

				return result;
			};
		};
	};

	window.wroterFrontend = new WroterFrontend();
} )( jQuery );

jQuery( function() {
	if ( ! wroterFrontend.isEditMode() ) {
		wroterFrontend.init();
	}
} );
