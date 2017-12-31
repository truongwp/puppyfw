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

		puppyfw()->helper->save_hooks( $page_data, $data );

		return rest_ensure_response( array(
			'updated' => true,
			'message' => esc_html__( 'Settings saved', 'puppyfw' ),
		) );
	}
}
