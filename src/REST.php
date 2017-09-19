<?php
/**
 * REST API handle
 *
 * @package PuppyFW
 */

namespace PuppyFW;

use WP_Error;
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
	 * @return WP_REST_Response|WP_Error
	 */
	public function save_settings( WP_REST_Request $request ) {
		if ( ! check_ajax_referer( 'wp_rest', '_wpnonce', false ) ) {
			return new WP_Error( 'permission-denied', __( 'Permission denied!', 'puppyfw' ) );
		}

		if ( ! $request->get_param( 'field_data' ) ) {
			return new WP_Error( 'empty-data', esc_html__( 'Empty settings data.', 'puppyfw' ) );
		}

		$data = $request->get_param( 'field_data' );
		$page_data = $request->get_param( 'page_data' );
		$option_name = ! empty( $page_data['option_name'] ) ? $page_data['option_name'] : '';
		$option_value = array();

		if ( ! current_user_can( $page_data['capability'] ) ) {
			return new WP_Error( 'permission-denied', __( 'Permission denied!', 'puppyfw' ) );
		}

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
