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
