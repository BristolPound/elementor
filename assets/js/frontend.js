(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
var ElementsHandler;

ElementsHandler = function( $ ) {
	var registeredHandlers = {},
		registeredGlobalHandlers = [];

	var runGlobalHandlers = function( $scope ) {
		$.each( registeredGlobalHandlers, function() {
			this.call( $scope, $ );
		} );
	};

	this.addHandler = function( widgetType, callback ) {
		registeredHandlers[ widgetType ] = callback;
	};

	this.addGlobalHandler = function( callback ) {
		registeredGlobalHandlers.push( callback );
	};

	this.runReadyTrigger = function( $scope ) {
		var elementType = $scope.data( 'element_type' );

		if ( ! elementType ) {
			return;
		}

		runGlobalHandlers( $scope );

		if ( ! registeredHandlers[ elementType ] ) {
			return;
		}

		registeredHandlers[ elementType ].call( $scope, $ );
	};
};

module.exports = ElementsHandler;

},{}],2:[function(require,module,exports){
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

},{"wroter-frontend/elements-handler":1,"wroter-frontend/handlers/accordion":3,"wroter-frontend/handlers/alert":4,"wroter-frontend/handlers/counter":5,"wroter-frontend/handlers/global":6,"wroter-frontend/handlers/image-carousel":7,"wroter-frontend/handlers/menu-anchor":8,"wroter-frontend/handlers/progress":9,"wroter-frontend/handlers/section":10,"wroter-frontend/handlers/tabs":11,"wroter-frontend/handlers/toggle":12,"wroter-frontend/handlers/video":13,"wroter-frontend/utils":14}],3:[function(require,module,exports){
var activateSection = function( sectionIndex, $accordionTitles ) {
	var $activeTitle = $accordionTitles.filter( '.active' ),
		$requestedTitle = $accordionTitles.filter( '[data-section="' + sectionIndex + '"]' ),
		isRequestedActive = $requestedTitle.hasClass( 'active' );

	$activeTitle
		.removeClass( 'active' )
		.next()
		.slideUp();

	if ( ! isRequestedActive ) {
		$requestedTitle
			.addClass( 'active' )
			.next()
			.slideDown();
	}
};

module.exports = function( $ ) {
	var $this = $( this ),
		defaultActiveSection = $this.find( '.wroter-accordion' ).data( 'active-section' ),
		$accordionTitles = $this.find( '.wroter-accordion-title' );

	if ( ! defaultActiveSection ) {
		defaultActiveSection = 1;
	}

	activateSection( defaultActiveSection, $accordionTitles );

	$accordionTitles.on( 'click', function() {
		activateSection( this.dataset.section, $accordionTitles );
	} );
};

},{}],4:[function(require,module,exports){
module.exports = function( $ ) {
	$( this ).find( '.wroter-alert-dismiss' ).on( 'click', function() {
		$( this ).parent().fadeOut();
	} );
};

},{}],5:[function(require,module,exports){
module.exports = function( $ ) {
	this.find( '.wroter-counter-number' ).waypoint( function() {
		var $number = $( this );

		$number.numerator( {
			duration: $number.data( 'duration' )
		} );
	}, { offset: '90%' } );
};

},{}],6:[function(require,module,exports){
module.exports = function() {
	if ( wroterFrontend.isEditMode() ) {
		return;
	}

	var $element = this,
		animation = $element.data( 'animation' );

	if ( ! animation ) {
		return;
	}

	$element.addClass( 'wroter-invisible' ).removeClass( animation );

	$element.waypoint( function() {
		$element.removeClass( 'wroter-invisible' ).addClass( animation );
	}, { offset: '90%' } );

};

},{}],7:[function(require,module,exports){
module.exports = function( $ ) {
	var $carousel = $( this ).find( '.wroter-image-carousel' );
	if ( ! $carousel.length ) {
		return;
	}

	var savedOptions = $carousel.data( 'slider_options' ),
		tabletSlides = 1 === savedOptions.slidesToShow ? 1 : 2,
		defaultOptions = {
			responsive: [
				{
					breakpoint: 767,
					settings: {
						slidesToShow: tabletSlides,
						slidesToScroll: tabletSlides
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
				}
			]
		},

		slickOptions = $.extend( {}, defaultOptions, $carousel.data( 'slider_options' ) );

	$carousel.slick( slickOptions );
};

},{}],8:[function(require,module,exports){
module.exports = function( $ ) {
	if ( wroterFrontend.isEditMode() ) {
		return;
	}

	var $anchor = this.find( '.wroter-menu-anchor' ),
		anchorID = $anchor.attr( 'id' ),
		$anchorLinks = $( 'a[href*="#' + anchorID + '"]' ),
		$scrollable = $( 'html, body' ),
		adminBarHeight = $( '#wpadminbar' ).height();

	$anchorLinks.on( 'click', function( event ) {
		var isSamePathname = ( location.pathname === this.pathname ),
			isSameHostname = ( location.hostname === this.hostname );

		if ( ! isSameHostname || ! isSamePathname ) {
			return;
		}

		event.preventDefault();

		$scrollable.animate( {
			scrollTop: $anchor.offset().top - adminBarHeight
		}, 1000 );
	} );
};

},{}],9:[function(require,module,exports){
module.exports = function( $ ) {
	var interval = 80;

	$( this ).find( '.wroter-progress-bar' ).waypoint( function() {
		var $progressbar = $( this ),
			max = parseInt( $progressbar.data( 'max' ), 10 ),
			$inner = $progressbar.next(),
			$innerTextWrap = $inner.find( '.wroter-progress-text' ),
			$percent = $inner.find( '.wroter-progress-percentage' ),
			innerText = $inner.data( 'inner' ) ? $inner.data( 'inner' ) : '';

		$progressbar.css( 'width', max + '%' );
		$inner.css( 'width', max + '%' );
		$innerTextWrap.html( innerText + '' );
		$percent.html(  max + '%' );

	}, { offset: '90%' } );
};

},{}],10:[function(require,module,exports){
var BackgroundVideo = function( $, $backgroundVideoContainer ) {
	var player,
		elements = {},
		isYTVideo = false;

	var calcVideosSize = function() {
		var containerWidth = $backgroundVideoContainer.outerWidth(),
			containerHeight = $backgroundVideoContainer.outerHeight(),
			aspectRatioSetting = '16:9', //TEMP
			aspectRatioArray = aspectRatioSetting.split( ':' ),
			aspectRatio = aspectRatioArray[ 0 ] / aspectRatioArray[ 1 ],
			ratioWidth = containerWidth / aspectRatio,
			ratioHeight = containerHeight * aspectRatio,
			isWidthFixed = containerWidth / containerHeight > aspectRatio;

		return {
			width: isWidthFixed ? containerWidth : ratioHeight,
			height: isWidthFixed ? ratioWidth : containerHeight
		};
	};

	var changeVideoSize = function() {
		var $video = isYTVideo ? $( player.getIframe() ) : elements.$backgroundVideo,
			size = calcVideosSize();

		$video.width( size.width ).height( size.height );
	};

	var prepareYTVideo = function( YT, videoID ) {
		player = new YT.Player( elements.$backgroundVideo[ 0 ], {
			videoId: videoID,
			events: {
				onReady: function() {
					player.mute();

					changeVideoSize();

					player.playVideo();
				},
				onStateChange: function( event ) {
					if ( event.data === YT.PlayerState.ENDED ) {
						player.seekTo( 0 );
					}
				}
			},
			playerVars: {
				controls: 0,
				showinfo: 0
			}
		} );

		$( wroterFrontend.getScopeWindow() ).on( 'resize', changeVideoSize );
	};

	var initElements = function() {
		elements.$backgroundVideo = $backgroundVideoContainer.children( '.wroter-background-video' );
	};

	var run = function() {
		var videoID = elements.$backgroundVideo.data( 'video-id' );

		if ( videoID ) {
			isYTVideo = true;

			wroterFrontend.utils.onYoutubeApiReady( function( YT ) {
				setTimeout( function() {
					prepareYTVideo( YT, videoID );
				}, 1 );
			} );
		} else {
			elements.$backgroundVideo.one( 'canplay', changeVideoSize );
		}
	};

	var init = function() {
		initElements();
		run();
	};

	init();
};

var StretchedSection = function( $, $section ) {
	var elements = {},
		settings = {};

	var stretchSection = function() {
		// Clear any previously existing css associated with this script
		$section.css( {
			'width': 'auto',
			'left': '0'
		} );

		if ( ! $section.hasClass( 'wroter-section-stretched' ) ) {
			return;
		}

		var sectionWidth = elements.$scopeWindow.width(),
			sectionOffset = $section.offset().left,
			correctOffset = sectionOffset;

		if ( elements.$sectionContainer.length ) {
			var containerOffset = elements.$sectionContainer.offset().left;

			sectionWidth = elements.$sectionContainer.outerWidth();

			if ( sectionOffset > containerOffset ) {
				correctOffset = sectionOffset - containerOffset;
			} else {
				correctOffset = 0;
			}
		}

		if ( ! settings.is_rtl ) {
			correctOffset = -correctOffset;
		}

		$section.css( {
			'width': sectionWidth + 'px',
			'left': correctOffset + 'px'
		} );
	};

	var initSettings = function() {
		settings.sectionContainerSelector = wroterFrontend.config.stretchedSectionContainer;
		settings.is_rtl = wroterFrontend.config.is_rtl;
	};

	var initElements = function() {
		elements.scopeWindow = wroterFrontend.getScopeWindow();
		elements.$scopeWindow = $( elements.scopeWindow );
		elements.$sectionContainer = $( elements.scopeWindow.document ).find( settings.sectionContainerSelector );
	};

	var bindEvents = function() {
		elements.$scopeWindow.on( 'resize', stretchSection );
	};

	var init = function() {
		initSettings();
		initElements();
		bindEvents();
		stretchSection();
	};

	init();
};

module.exports = function( $ ) {
	new StretchedSection( $, this );

	var $backgroundVideoContainer = this.find( '.wroter-background-video-container' );

	if ( $backgroundVideoContainer ) {
		new BackgroundVideo( $, $backgroundVideoContainer );
	}
};

},{}],11:[function(require,module,exports){
module.exports = function( $ ) {
	var $this = $( this ),
		defaultActiveTab = $this.find( '.wroter-tabs' ).data( 'active-tab' ),
		$tabsTitles = $this.find( '.wroter-tab-title' ),
		$tabs = $this.find( '.wroter-tab-content' ),
		$active,
		$content;

	if ( ! defaultActiveTab ) {
		defaultActiveTab = 1;
	}

	var activateTab = function( tabIndex ) {
		if ( $active ) {
			$active.removeClass( 'active' );

			$content.hide();
		}

		$active = $tabsTitles.filter( '[data-tab="' + tabIndex + '"]' );

		$active.addClass( 'active' );

		$content = $tabs.filter( '[data-tab="' + tabIndex + '"]' );

		$content.show();
	};

	activateTab( defaultActiveTab );

	$tabsTitles.on( 'click', function() {
		activateTab( this.dataset.tab );
	} );
};

},{}],12:[function(require,module,exports){
module.exports = function( $ ) {
	var $toggleTitles = $( this ).find( '.wroter-toggle-title' );

	$toggleTitles.on( 'click', function() {
		var $active = $( this ),
			$content = $active.next();

		if ( $active.hasClass( 'active' ) ) {
			$active.removeClass( 'active' );
			$content.slideUp();
		} else {
			$active.addClass( 'active' );
			$content.slideDown();
		}
	} );
};

},{}],13:[function(require,module,exports){
module.exports = function( $ ) {
	var $this = $( this ),
		$imageOverlay = $this.find( '.wroter-custom-embed-image-overlay' ),
		$videoFrame = $this.find( 'iframe' );

	if ( ! $imageOverlay.length ) {
		return;
	}

	$imageOverlay.on( 'click', function() {
		$imageOverlay.remove();
		var newSourceUrl = $videoFrame[0].src;
		// Remove old autoplay if exists
		newSourceUrl = newSourceUrl.replace( '&autoplay=0', '' );

		$videoFrame[0].src = newSourceUrl + '&autoplay=1';
	} );
};

},{}],14:[function(require,module,exports){
var Utils;

Utils = function( $ ) {
	var self = this;

	this.onYoutubeApiReady = function( callback ) {
		if ( window.YT && YT.loaded ) {
			callback( YT );
		} else {
			// If not ready check again by timeout..
			setTimeout( function() {
				self.onYoutubeApiReady( callback );
			}, 350 );
		}
	};

	this.insertYTApi = function() {
		$( 'script:first' ).before(  $( '<script>', { src: 'https://www.youtube.com/iframe_api' } ) );
	};
};

module.exports = Utils;

},{}]},{},[2])
//# sourceMappingURL=frontend.js.map
