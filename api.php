<?php
/**
 * Plugin API functions
 *
 * @package PuppyFW
 * @since 1.0.0
 */

/**
 * Gets option value.
 * This method automatically get default value if value is not set.
 *
 * @param  string $page_id   Option page ID.
 * @param  string $option_id Option ID.
 * @return mixed
 */
function puppyfw_get_option( $page_id, $option_id ) {
	$page = puppyfw()->get_page( $page_id );

	if ( ! $page ) {
		return null;
	}

	return $page->get_option( $option_id );
}


/**
 * Gets meta box value.
 * This method automatically get default value if value is not set.
 *
 * @param  int    $post_id     Post ID.
 * @param  string $meta_box_id Meta box ID.
 * @param  string $option_id   Option ID.
 * @return mixed
 */
function puppyfw_get_post_meta( $post_id, $meta_box_id, $option_id ) {
	$page = puppyfw()->get_page( $meta_box_id, 'meta_box' );

	if ( ! $page ) {
		return null;
	}

	$page->storage->set_post_id( $post_id );
	return $page->get_option( $option_id );
}
