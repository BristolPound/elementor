module.exports = function( $ ) {
	this.find( '.wroter-counter-number' ).waypoint( function() {
		var $number = $( this );

		$number.numerator( {
			duration: $number.data( 'duration' )
		} );
	}, { offset: '90%' } );
};
