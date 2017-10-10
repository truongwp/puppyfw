<?php
/**
 * Helper functions.
 *
 * @package PuppyFW
 */

namespace PuppyFW;

/**
 * Class Helpers
 */
class Helpers {

	/**
	 * Converts field type to camel case.
	 *
	 * @param  string $string String need to be converted.
	 * @return string
	 */
	public static function to_camel_case( $string ) {
		$string = str_replace( array( '-', '_' ), ' ', $string );
		$string = ucwords( $string );
		$string = str_replace( ' ', '', $string );
		return $string;
	}

	/**
	 * Converts field type to snake case.
	 *
	 * @since 0.3.0
	 *
	 * @param  string $string String need to be converted.
	 * @return string
	 */
	public static function to_snake_case( $string ) {
		$string = str_replace( array( '-', '_' ), ' ', $string );
		$string = ucwords( $string );
		$string = str_replace( ' ', '_', $string );
		return $string;
	}

	/**
	 * Gets field type mapping.
	 *
	 * @return array
	 */
	public static function field_type_mapping() {
		return apply_filters( 'puppyfw_field_type_mapping', array(
			'text'        => 'input',
			'number'      => 'input',
			'email'       => 'input',
			'tel'         => 'input',
			'post_select' => 'select',
		) );
	}

	/**
	 * Gets field vue component mapping.
	 *
	 * @return array
	 */
	public static function field_vue_component_mapping() {
		$mapping = self::field_type_mapping();
		return apply_filters( 'puppyfw_field_vue_component_mapping', $mapping );
	}

	/**
	 * Gets mapped type.
	 *
	 * @param  string $type Field type.
	 * @return string
	 */
	public static function get_mapped_type( $type ) {
		$types = self::field_type_mapping();

		if ( isset( $types[ $type ] ) ) {
			return $types[ $type ];
		}

		return $type;
	}

	/**
	 * Normalizes page data.
	 *
	 * @since 0.3.0
	 *
	 * @param  array $page_data Page data.
	 * @return array
	 */
	public static function normalize_page( $page_data ) {
		return wp_parse_args( $page_data, array(
			'parent_slug' => '',
			'page_title'  => '',
			'menu_title'  => '',
			'capability'  => 'manage_options',
			'menu_slug'   => '',
			'icon_url'    => '',
			'position'    => 100,
			'option_name' => '',
		) );
	}
}
