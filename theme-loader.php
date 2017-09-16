<?php
/**
 * Loader file for plugins and composer
 *
 * @package PuppyFW
 */

if ( defined( 'PUPPYFW_VERSION' ) ) {
	return;
}

define( 'PUPPYFW_VERSION', '0.1.0' );
define( 'PUPPYFW_PATH', get_template_directory() . '/puppyfw/' );
define( 'PUPPYFW_URL', get_template_directory_uri() . '/puppyfw/' );

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
