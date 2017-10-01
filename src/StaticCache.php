<?php
/**
 * Static cache class
 * Cache options value for multiple get option call
 *
 * @package PuppyFW
 * @author Truong Giang <truongwp@gmail.com>
 * @version 1.0.0
 */

namespace PuppyFW;

/**
 * Class StaticCache
 */
class StaticCache {

	/**
	 * Stored data.
	 *
	 * @var array
	 */
	protected static $data = array();

	/**
	 * Sets data.
	 *
	 * @param string $key   Option name.
	 * @param mixed  $value Option value.
	 */
	public static function set( $key, $value ) {
		self::$data[ $key ] = $value;
	}

	/**
	 * Gets data.
	 *
	 * @param  string $key Option name.
	 * @return mixed       Option value.
	 */
	public static function get( $key ) {
		if ( isset( self::$data[ $key ] ) ) {
			return self::$data[ $key ];
		}
		return null;
	}
}
