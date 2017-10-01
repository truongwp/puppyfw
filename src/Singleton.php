<?php
/**
 * Singleton class
 *
 * @package PuppyFW
 * @author Truong Giang <truongwp@gmail.com>
 * @version 1.0.0
 */

namespace PuppyFW;

/**
 * Class Singleton
 */
class Singleton {

	/**
	 * Class instance.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Gets class instance.
	 *
	 * @return object
	 */
	public static function get_instance() {
		if ( ! static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Constructor.
	 */
	protected function __construct() {}

	/**
	 * Clone magic method.
	 */
	protected function __clone() {}

	/**
	 * Wakeup magic method.
	 */
	protected function __wakeup() {}
}
