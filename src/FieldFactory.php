<?php
/**
 * Field factory class
 *
 * @package PuppyFW
 */

namespace PuppyFW;

/**
 * Class FieldFactory
 */
class FieldFactory {

	/**
	 * Get field object.
	 *
	 * @param  array $field_data Field data.
	 * @return Field
	 */
	public static function get_field( $field_data ) {
		if ( ! empty( $field_data['repeatable'] ) ) {
			$field_data['repeat_field_type'] = $field_data['type'];
			$field_data['type'] = 'repeatable';
		}
		$class_name = self::get_field_class( $field_data );
		return new $class_name( $field_data );
	}

	/**
	 * Gets field class name.
	 *
	 * @param  array $field_data Field data.
	 * @return string
	 */
	public static function get_field_class( $field_data ) {
		$type = ! empty( $field_data['type'] ) ? $field_data['type'] : 'input';
		$mapped_type = puppyfw()->helper->get_mapped_type( $type );
		$class_name = '\\PuppyFW\\Fields\\' . puppyfw()->helper->to_camel_case( $mapped_type );

		if ( ! class_exists( $class_name ) ) {
			$class_name = '\\PuppyFW\\Fields\\Input';
		}

		return apply_filters( 'puppyfw_field_class_name', $class_name, $field_data );
	}
}
