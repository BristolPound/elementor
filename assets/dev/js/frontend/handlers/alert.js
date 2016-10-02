module.exports = function( $ ) {
	$( this ).find( '.wroter-alert-dismiss' ).on( 'click', function() {
		$( this ).parent().fadeOut();
	} );
};
