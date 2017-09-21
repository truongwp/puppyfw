<?php
/**
 * Plugin Name:     PuppyFW
 * Plugin URI:      https://puppyfw.com/
 * Description:     A framework for WordPress use Vuejs.
 * Author:          Truong Giang
 * Author URI:      https://truongwp.com/
 * Text Domain:     puppyfw
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         PuppyFW
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * PuppyFW only works in WordPress 4.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.6', '<' ) ) {
	/**
	 * Prints an update nag after an unsuccessful attempt to active
	 * PuppyFW on WordPress versions prior to 4.6.
	 *
	 * @global string $wp_version WordPress version.
	 */
	function puppyfw_wordpress_upgrade_notice() {
		$message = sprintf( esc_html__( 'PuppyFW requires at least WordPress version 4.6, you are running version %s. Please upgrade and try again!', 'puppyfw' ), $GLOBALS['wp_version'] );
		printf( '<div class="error"><p>%s</p></div>', $message ); // WPCS: XSS OK.

		deactivate_plugins( array( 'puppyfw/puppyfw.php' ) );
	}

	add_action( 'admin_notices', 'puppyfw_wordpress_upgrade_notice' );
	return;
}

/**
 * And only works with PHP 5.6.4 or later.
 */
if ( version_compare( phpversion(), '5.6.4', '<' ) ) {
	/**
	 * Adds a message for outdate PHP version.
	 */
	function puppyfw_php_upgrade_notice() {
		$message = sprintf( esc_html__( 'PuppyFW requires at least PHP version 5.6.4 to works, you are running version %s. Please contact to your administrator to upgrade PHP version!', 'puppyfw' ), phpversion() );
		printf( '<div class="error"><p>%s</p></div>', $message ); // WPCS: XSS OK.

		deactivate_plugins( array( 'puppyfw/puppyfw.php' ) );
	}

	add_action( 'admin_notices', 'puppyfw_php_upgrade_notice' );
	return;
}
