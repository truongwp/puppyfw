<?php
/**
 * Loader file for plugins and composer
 *
 * @package PuppyFW
 */

if ( function_exists( 'puppyfw' ) ) {
	return;
}

// Change two constants below to your own paths.
define( 'PUPPYFW_PATH', get_template_directory() . '/puppyfw/' );
define( 'PUPPYFW_URL', get_template_directory_uri() . '/puppyfw/' );

require_once PUPPYFW_PATH . 'vendor/autoload.php';
