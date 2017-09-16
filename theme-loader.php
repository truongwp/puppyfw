<?php
/**
 * Loader file for plugins and composer
 *
 * @package PuppyFW
 */

if ( defined( 'PUPPYPRESS_VERSION' ) ) {
	return;
}

define( 'PUPPYPRESS_VERSION', '0.1.0' );
define( 'PUPPYPRESS_PATH', get_template_directory() . '/puppyfw/' );
define( 'PUPPYPRESS_URL', get_template_directory_uri() . '/puppyfw/' );

require_once PUPPYPRESS_PATH . 'vendor/autoload.php';

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

// Example. Remove when completed.
require_once PUPPYPRESS_PATH . 'demo/demo.php';
