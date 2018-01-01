<?php
/**
 * Core functions
 *
 * @package PuppyFW
 */

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

/**
 * Saves options page.
 *
 * @since 1.0.0
 *
 * @param array $page_data Page data.
 * @param array $save_data Save data.
 * @param array $args      Custom arguments.
 */
function puppyfw_save_option( $page_data, $save_data, $args = array() ) {
	$page = puppyfw()->factory->create_page( $page_data );
	$check = $page->check_permission();
	if ( is_wp_error( $check ) ) {
		return $check;
	}

	$option_name = ! empty( $page_data['option_name'] ) ? $page_data['option_name'] : '';
	$option_value = array();

	foreach ( $save_data as $field_data ) {
		if ( empty( $field_data['id'] ) ) {
			continue;
		}

		$id = $field_data['id'];
		$value = isset( $field_data['value'] ) ? $field_data['value'] : null;
		$type = ! empty( $field_data['type'] ) ? $field_data['type'] : 'input';

		/**
		 * Filters value of a field type before saving.
		 *
		 * @since 0.1.0
		 *
		 * @param mixed  $value Field value.
		 * @param string $id    Field ID.
		 */
		$value = apply_filters( "puppyfw_save_{$type}_value", $value, $id );

		// Save in separate rows.
		if ( ! $option_name ) {
			if ( is_null( $value ) ) {
				$page->storage->delete( $id );
			} else {
				$page->storage->update( $id, $value );
			}

			continue;
		}

		// Save in single row.
		if ( ! is_null( $value ) ) {
			$option_value[ $id ] = $value;
		}
	}

	if ( $option_name ) {
		$page->storage->update( $option_name, $option_value );
	}
}
add_action( 'puppyfw_save_option', 'puppyfw_save_option', 10, 3 );
