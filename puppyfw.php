<?php
/**
 * Plugin Name:     PuppyFW
 * Plugin URI:      https://puppyfw.com/
 * Description:     PuppyFW is a lightweight but powerful options framework for WordPress themes and plugins which supports tab, group, repeatable, field dependencies. It comes with Options Page Builder so doesn't require coding skills to use.
 * Author:          Truong Giang
 * Author URI:      https://truongwp.com/
 * Text Domain:     puppyfw
 * Domain Path:     /languages
 * Version:         0.4.2
 *
 * @package         PuppyFW
 */

if ( function_exists( 'puppyfw' ) ) {
	return;
}

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
