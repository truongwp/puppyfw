<?php
/**
 * Framework loader
 *
 * @package PuppyFW
 */

if ( defined( 'PUPPYFW_VERSION' ) ) {
	return;
}

define( 'PUPPYFW_VERSION', '0.1.0' );

if ( ! defined( 'PUPPYFW_PATH' ) ) {
	define( 'PUPPYFW_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'PUPPYFW_URL' ) ) {
	define( 'PUPPYFW_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Framework initialize.
 */
function puppyfw_init() {
	$framework = new \PuppyFW\Framework();

	/**
	 * Registers settings for framework.
	 *
	 * @since 0.1.0
	 *
	 * @param Framework $framework Framework instance.
	 */
	do_action( 'puppyfw_init', $framework );

	$framework->init();

	( new \PuppyFW\REST() )->init();
}
add_action( 'init', 'puppyfw_init' );

/**
 * Load Localisation files.
 */
function puppyfw_load_plugin_textdomain() {
	load_plugin_textdomain( 'puppyfw', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'puppyfw_load_plugin_textdomain' );
