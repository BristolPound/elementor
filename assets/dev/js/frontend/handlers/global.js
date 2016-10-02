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
