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
