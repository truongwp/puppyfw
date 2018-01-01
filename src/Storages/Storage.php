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
	 * @param array  $args  Custom arguments.
	 */
	public function add( $name, $value, $args = array() );

	/**
	 * Updates a value.
	 *
	 * @param string $name  Name.
	 * @param mixed  $value Value.
	 * @param array  $args  Custom arguments.
	 */
	public function update( $name, $value, $args = array() );

	/**
	 * Gets a value.
	 *
	 * @param string $name Name.
	 * @param array  $args Custom arguments.
	 * @return mixed       Value.
	 */
	public function get( $name, $args = array() );

	/**
	 * Deletes a value.
	 *
	 * @param string $name Name.
	 * @param array  $args Custom arguments.
	 */
	public function delete( $name, $args = array() );
}
