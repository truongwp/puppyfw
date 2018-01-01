<?php
/**
 * Factory class
 *
 * @package PuppyFW
 * @since 1.0.0
 */

namespace PuppyFW;

/**
 * Factory class
 */
class Factory {

	/**
	 * Creates page from page data.
	 *
	 * @param  array $page_data Page data.
	 * @return Page
	 */
	public function create_page( $page_data ) {
		$page_class = puppyfw()->helper->get_page_class( $page_data );
		return new $page_class( $page_data );
	}
}
