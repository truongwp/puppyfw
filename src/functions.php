<?php
/**
 * Core functions
 *
 * @package PuppyFW
 */

/**
 * Gets page instance.
 *
 * @param  string $page_slug Page slug.
 * @return \PuppyFW\Page
 */
function puppyfw_get_page( $page_slug ) {
	$pages = puppyfw()->get_pages();
}

/**
 * Filters save value of checkbox field.
 *
 * @param  mixed $value Checkbox save value.
 * @return bool
 */
function puppyfw_filter_checkbox_save_value( $value ) {
	if ( ! is_bool( $value ) ) {
		return 'true' == $value;
	}
	return $value;
}
add_filter( 'puppyfw_save_checkbox_value', 'puppyfw_filter_checkbox_save_value' );

