<?php
/**
 * Storage interface
 *
 * @package PuppyFW\Storages
 * @since 1.0.0
 */

namespace PuppyFW\Storages;

/**
 * Storage interface
 */
interface Storage {

	/**
	 * Adds a value.
	 *
	 * @param string $name  Name.
	 * @param mixed  $value Value.
	 */
	public function add( $name, $value );

	/**
	 * Updates a value.
	 *
	 * @param string $name  Name.
	 * @param mixed  $value Value.
	 */
	public function update( $name, $value );

	/**
	 * Gets a value.
	 *
	 * @param string $name    Name.
	 * @param mixed  $default Default value.
	 * @return mixed          Value.
	 */
	public function get( $name, $default = '' );

	/**
	 * Deletes a value.
	 *
	 * @param string $name Name.
	 */
	public function delete( $name );
}
