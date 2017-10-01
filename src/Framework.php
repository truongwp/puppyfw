<?php
/**
 * Framework class
 *
 * @package PuppyFW
 */

namespace PuppyFW;

/**
 * Class Framework
 */
class Framework {

	/**
	 * Settings pages.
	 *
	 * @var array
	 */
	protected $pages = array();

	/**
	 * Adds page.
	 *
	 * @param array $page_data Page data.
	 * @return Page|false
	 */
	public function add_page( $page_data ) {
		if ( empty( $page_data['menu_slug'] ) ) {
			return false;
		}

		$page = new Page( $page_data );
		$this->pages[ $page_data['menu_slug'] ] = $page;
		return $page;
	}

	/**
	 * Framework initialize.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'init_pages' ) );
	}

	/**
	 * Runs options pages.
	 */
	public function init_pages() {
		foreach ( $this->pages as $page ) {
			$page->init();
		}
	}
}
