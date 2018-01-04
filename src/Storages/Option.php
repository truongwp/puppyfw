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
	 */
	public function add( $name, $value ) {
		return add_option( $name, $value );
	}

	/**
	 * Updates a value.
	 *
	 * @param string $name  Name.
	 * @param mixed  $value Value.
	 */
	public function update( $name, $value ) {
		return update_option( $name, $value );
	}

	/**
	 * Gets a value.
	 *
	 * @param string $name    Name.
	 * @param mixed  $default Default value.
	 * @return mixed          Value.
	 */
	public function get( $name, $default = '' ) {
		return get_option( $name, $default );
	}

	/**
	 * Deletes a value.
	 *
	 * @param string $name Name.
	 */
	public function delete( $name ) {
		return delete_option( $name );
	}
}
