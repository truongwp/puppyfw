<?php
/**
 * Framework loader
 *
 * @package PuppyFW
 */

if ( ! defined( 'PUPPYFW_PATH' ) ) {
	define( 'PUPPYFW_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'PUPPYFW_URL' ) ) {
	define( 'PUPPYFW_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Gets framework instance.
 *
 * @return \PuppyFW\Framework
 */
function puppyfw() {
	return \PuppyFW\Framework::get_instance();
}

/**
 * Framework init.
 */
function puppyfw_init() {
	$framework = puppyfw();

	/**
	 * Fires before init framework.
	 *
	 * @since 0.3.0
	 *
	 * @param \PuppyFW\Framework $framework Framework instance.
	 */
	do_action( 'puppyfw_before_init', $framework );

	/**
	 * Registers settings for framework.
	 *
	 * @since 0.1.0
	 *
	 * @param \PuppyFW\Framework $framework Framework instance.
	 */
	do_action( 'puppyfw_init', $framework );

	$framework->init();

	/**
	 * Fires after init framework.
	 *
	 * @since 0.2.0
	 *
	 * @param \PuppyFW\Framework $framework Framework instance.
	 */
	do_action( 'puppyfw_after_init', $framework );
}
add_action( 'plugins_loaded', 'puppyfw_init' );


/**
 * Runs something before init framework.
 *
 * @param \PuppyFW\Framework $framework Framework instance.
 */
function puppyfw_before_init( \PuppyFW\Framework $framework ) {
	\PuppyFW\StaticCache::set( 'rendered_fields', array() );

	$rest = new \PuppyFW\REST();
	$rest->init();

	/**
	 * Filters for enabling/disabling options page builder.
	 *
	 * @since 0.3.0
	 *
	 * @param bool $enable Whether to enable options page builder or not.
	 */
	if ( apply_filters( 'puppyfw_show_builder', true ) ) {
		$builder = new \PuppyFW\Builder\Builder();
		$builder->init();
	}
}
add_action( 'puppyfw_before_init', 'puppyfw_before_init' );


/**
 * Load Localisation files.
 */
function puppyfw_load_plugin_textdomain() {
	load_plugin_textdomain( 'puppyfw', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'puppyfw_load_plugin_textdomain' );


/**
 * Gets option api.
 * This method automatically get default value if value is not set.
 *
 * @since 0.2.0
 *
 * @param  string $page_slug Option page slug.
 * @param  string $option_id Option ID.
 * @return mixed
 */
function puppyfw_get_option( $page_slug, $option_id ) {
	$page = puppyfw()->get_page( $page_slug );

	if ( ! $page ) {
		return null;
	}

	return $page->get_option( $option_id );
}
