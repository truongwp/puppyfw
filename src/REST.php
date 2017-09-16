<?php
/**
 * REST API handle
 *
 * @package PuppyFW
 */

namespace PuppyFW;

use WP_REST_Request;

/**
 * Class REST
 */
class REST {

	const ROUTE_NAMESPACE = 'puppyfw';

	/**
	 * Class init.
	 */
	public function init() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register rest routes.
	 */
	public function register_routes() {
		register_rest_route( self::ROUTE_NAMESPACE, '/settings', array(
			'methods'  => \WP_REST_Server::EDITABLE,
			'callback' => array( $this, 'save_settings' ),
		) );
	}

	/**
	 * Save settings handle.
	 *
	 * @param  WP_REST_Request $request Request object.
	 * @return object
	 */
	public function save_settings( WP_REST_Request $request ) {
		check_ajax_referer( 'wp_rest' );

		if ( ! $request->get_param( 'field_data' ) ) {
			return rest_ensure_response( esc_html__( 'Empty settings data.', 'puppyfw' ) );
		}

		$data = $request->get_param( 'field_data' );
		$page_data = $request->get_param( 'page_data' );
		$option_name = ! empty( $page_data['option_name'] ) ? $page_data['option_name'] : '';
		$option_value = array();

		foreach ( $data as $field_data ) {
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
					delete_option( $id );
				} else {
					update_option( $id, $value );
				}

				continue;
			}

			// Save in single row.
			if ( ! is_null( $value ) ) {
				$option_value[ $id ] = $value;
			}
		}

		if ( $option_name ) {
			update_option( $option_name, $option_value );
		}

		return rest_ensure_response( array(
			'updated' => true,
			'message' => esc_html__( 'Settings saved', 'puppyfw' ),
		) );
	}
}
