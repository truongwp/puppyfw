<?php
/**
 * Helper functions
 *
 * @package PuppyFW
 * @since 1.0.0
 */

namespace PuppyFW;

/**
 * Helper class
 */
class Helper {

	/**
	 * Calls save hooks.
	 *
	 * @param array $page_data Page data.
	 * @param array $save_data Save data.
	 * @param array $args      Custom arguments.
	 */
	public function save_hooks( $page_data, $save_data, $args = array() ) {
		/**
		 * Fires when save option of a specific page type.
		 *
		 * @since 1.0.0
		 *
		 * @param array $page_data Page data.
		 * @param array $save_data Save data.
		 * @param array $args      Custom arguments.
		 */
		do_action( "puppyfw_save_option_{$page_data['type']}", $page_data, $save_data, $args );

		/**
		 * Fires when save option.
		 *
		 * @since 1.0.0
		 *
		 * @param array $page_data Page data.
		 * @param array $save_data Save data.
		 * @param array $args      Custom arguments.
		 */
		do_action( 'puppyfw_save_option', $page_data, $save_data, $args );
	}
}
