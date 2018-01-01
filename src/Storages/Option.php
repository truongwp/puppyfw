<?php
/**
 * Option storage
 *
 * @package PuppyFW\Storages
 * @since 1.0.0
 */

namespace PuppyFW\Storages;

/**
 * Option class
 */
class Option implements Storage {

	/**
	 * Adds a value.
	 *
	 * @param string $name  Name.
	 * @param mixed  $value Value.
	 * @param array  $args  Custom arguments.
	 */
	public function add( $name, $value, $args = array() ) {
		$autoload = ! empty( $args['autoload'] ) ? 'yes' : '';
		return add_option( $name, $value, '', $autoload );
	}

	/**
	 * Updates a value.
	 *
	 * @param string $name  Name.
	 * @param mixed  $value Value.
	 * @param array  $args  Custom arguments.
	 */
	public function update( $name, $value, $args = array() ) {
		$autoload = ! empty( $args['autoload'] ) ? 'yes' : '';
		return update_option( $name, $value, $autoload );
	}

	/**
	 * Gets a value.
	 *
	 * @param string $name Name.
	 * @param array  $args Custom arguments.
	 * @return mixed       Value.
	 */
	public function get( $name, $args = array() ) {
		$default = ! empty( $args['default'] ) ? $args['default'] : '';
		return get_option( $name, $default );
	}

	/**
	 * Deletes a value.
	 *
	 * @param string $name Name.
	 * @param array  $args Custom arguments.
	 */
	public function delete( $name, $args = array() ) {
		return delete_option( $name );
	}
}
