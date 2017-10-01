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
	 * Converts snakecase to camel case.
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
}
