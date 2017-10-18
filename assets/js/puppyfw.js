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

	helper.isNonEmptyObject = function( obj ) {
		return typeof obj === 'object' && Object.keys( obj ).length && ! obj[0];
	};

	helper.getRandomString = function( length ) {
		if ( ! length ) {
			length = 5;
		}

		var str = '';
		var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

		for ( var i = 0; i < length; i++ ) {
			str += possible.charAt( Math.floor( Math.random() * possible.length ) );
		}

		return str;
	};

	helper.generateBaseId = function() {
		return 'base-id_' + helper.getRandomString();
	};

	helper.convertObjectToArray = function( obj ) {
		if ( ! helper.isNonEmptyObject( obj ) ) {
			return obj;
		}

		var arr = [];

		for ( var i in obj ) {
			arr.push({
				baseId: helper.generateBaseId(),
				key: i,
				value: obj[ i ]
			});
		}

		return arr;
	};

	helper.injectBaseId = function( arr ) {
		for ( var i = 0; i < arr.length; i++ ) {
			if ( ! arr[ i ].baseId ) {
				arr[ i ].baseId = helper.generateBaseId();
			}
		}
		return arr;
	};

})( window );
