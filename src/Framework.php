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
class Framework extends Singleton {

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
	 * Gets page instance.
	 *
	 * @param  string $page_slug Page slug.
	 * @return Page
	 */
	public function get_page( $page_slug ) {
		if ( ! isset( $this->pages[ $page_slug ] ) ) {
			return false;
		}
		return $this->pages[ $page_slug ];
	}

	/**
	 * Framework initialize.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'register_pages' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
	 * Registers options pages.
	 */
	public function register_pages() {
		foreach ( $this->pages as $page ) {
			$page->register();
		}
	}

	/**
	 * Registers scripts.
	 */
	public function scripts() {
		wp_enqueue_style( 'puppyfw-form', PUPPYFW_URL . 'assets/css/form.css', array(), '0.3.0' );

		wp_register_script( 'vue', PUPPYFW_URL . 'assets/js/lib/vue.min.js', array(), '2.4.4', true );

		wp_register_script( 'puppyfw', PUPPYFW_URL . 'assets/js/puppyfw.js', array(), '0.3.0', true );

		wp_register_script( 'puppyfw-components', PUPPYFW_URL . 'assets/js/components.js', array( 'vue', 'jquery-ui-datepicker' ), '0.1.0', true );

		wp_localize_script( 'puppyfw', 'puppyfw', array(
			'mapping' => Helpers::field_vue_component_mapping(),

			/**
			 * Filters i18n data.
			 *
			 * @since 0.3.0
			 *
			 * @param array $i18n I18n data.
			 */
			'i18n'    => apply_filters( 'puppyfw_i18n', array(
				'errorSaving' => __( 'Some errors occur when save data.', 'puppyfw' ),
			) ),
		) );
	}
}
