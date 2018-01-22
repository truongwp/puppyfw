/* global jQuery */
( function( $ ) {
	"use strict";

	/**
	 * Activates settings section for a specific options page type.
	 *
	 * @param {String} type Options page type.
	 */
	function activatePageSettings( type ) {
		$( '.puppyfw-settings-section' ).hide();
		$( '#puppyfw-settings-' + type ).fadeIn();
	}

	$( document ).ready( function() {
		activatePageSettings( $( '#puppyfw-page-type' ).val() );

		$( '#puppyfw-page-type' ).on( 'change', function() {
			activatePageSettings( $( this ).val() );
		});
	});
})( jQuery );
