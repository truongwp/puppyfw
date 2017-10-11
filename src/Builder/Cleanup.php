<?php
/**
 * Cleanup fields data before saving
 *
 * @package PuppyFW\Builder
 */

namespace PuppyFW\Builder;

/**
 * Class Cleanup
 */
class Cleanup {

	/**
	 * Cleans up field data.
	 *
	 * @param array $fields Fields data.
	 * @return array
	 */
	public function clean( $fields ) {
		foreach ( $fields as $index => $field ) {
			$this->clean_attrs( $field );
			$this->clean_options( $field );

			$fields[ $index ] = $field;
		}

		return $fields;
	}

	/**
	 * Cleans attrs parameter.
	 *
	 * @param array $field Field data.
	 */
	protected function clean_attrs( &$field ) {
		$attrs = array();
		$field['attrs'] = isset( $field['attrs'] ) ? (array) $field['attrs'] : array();
		foreach ( $field['attrs'] as $attr ) {
			if ( ! empty( $attr['key'] ) ) {
				$attrs[ $attr['key'] ] = $attr['value'];
			}
		}
		$field['attrs'] = $attrs;
	}

	/**
	 * Cleans options parameter.
	 *
	 * @param array $field Field data.
	 */
	protected function clean_options( &$field ) {
		$options = array();
		$field['options'] = isset( $field['options'] ) ? (array) $field['options'] : array();
		foreach ( $field['options'] as $attr ) {
			if ( ! empty( $attr['key'] ) ) {
				$options[ $attr['key'] ] = $attr['value'];
			}
		}
		$field['options'] = $options;
	}
}
