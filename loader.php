<?php
/**
 * Framework loader
 *
 * @package PuppyFW
 */

if ( defined( 'PUPPYFW_VERSION' ) ) {
	return;
}

define( 'PUPPYFW_VERSION', '0.1.2' );

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
	 * Registers settings for framework.
	 *
	 * @since 0.1.0
	 *
	 * @param Framework $framework Framework instance.
	 */
	do_action( 'puppyfw_init', $framework );

	$framework->init();

	/**
	 * Fires after init framework.
	 *
	 * @since 0.2.0
	 *
	 * @param Framework $framework Framework instance.
	 */
	do_action( 'puppyfw_after_init', $framework );

	$rest = new \PuppyFW\REST();
	$rest->init();
}
add_action( 'plugins_loaded', 'puppyfw_init' );

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
