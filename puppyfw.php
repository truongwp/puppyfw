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

if ( defined( 'PUPPYFW_VERSION' ) ) {
	return;
}

define( 'PUPPYFW_VERSION', '0.1.0' );
define( 'PUPPYFW_PATH', plugin_dir_path( __FILE__ ) );
define( 'PUPPYFW_URL', plugin_dir_url( __FILE__ ) );

require_once PUPPYFW_PATH . 'vendor/autoload.php';

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
