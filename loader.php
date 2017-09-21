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

/**
 * PuppyFW only works with WordPress 4.8 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.8', '<' ) ) {
	/**
	 * Prints an update nag after an unsuccessful attempt to active
	 * PuppyFW on WordPress versions prior to 4.8.
	 *
	 * @global string $wp_version WordPress version.
	 */
	function puppyfw_wordpress_upgrade_notice() {
		$message = sprintf( esc_html__( 'PuppyFW requires at least WordPress version 4.8, you are running version %s. Please upgrade and try again!', 'puppyfw' ), $GLOBALS['wp_version'] );
		printf( '<div class="error"><p>%s</p></div>', $message ); // WPCS: XSS OK.

		deactivate_plugins( array( 'puppyfw/puppyfw.php' ) );
	}

	add_action( 'admin_notices', 'puppyfw_wordpress_upgrade_notice' );
	return;
}

/**
 * And only works with PHP 5.3 or later.
 */
if ( version_compare( phpversion(), '5.3', '<' ) ) {
	/**
	 * Adds a message for outdate PHP version.
	 */
	function puppyfw_php_upgrade_notice() {
		$message = sprintf( esc_html__( 'PuppyFW requires at least PHP version 5.3 to work, you are running version %s. Please contact to your administrator to upgrade PHP version!', 'puppyfw' ), phpversion() );
		printf( '<div class="error"><p>%s</p></div>', $message ); // WPCS: XSS OK.

		deactivate_plugins( array( 'puppyfw/puppyfw.php' ) );
	}

	add_action( 'admin_notices', 'puppyfw_php_upgrade_notice' );
	return;
}
