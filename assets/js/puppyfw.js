( function( window ) {
	"use strict";

	window.puppyfw = window.puppyfw || {};

	var helper = window.puppyfw.helper = window.puppyfw.helper || {};

	/**
	 * Clones an object.
	 *
	 * @param  {Object} obj Object needs to be cloned.
	 * @return {Object}
	 */
	helper.clone = function( obj ) {
		return JSON.parse( JSON.stringify( obj ) );
	};

})( window );
