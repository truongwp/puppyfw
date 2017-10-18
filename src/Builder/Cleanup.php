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
			$this->clean_nested_fields( $field );
			$this->clean_tabs( $field );
			$this->clean_key_value_data( $field, 'attrs' );
			$this->clean_key_value_data( $field, 'options' );
			$this->clean_key_value_data( $field, 'js_options' );
			$this->normalize_image_default( $field );
			$this->normalize_images_default( $field );
			$this->normalize_dependency( $field );

			if ( ! empty( $field['fields'] ) ) {
				$field['fields'] = $this->clean( $field['fields'] );
			}

			$fields[ $index ] = $field;
		}

		return $fields;
	}

	/**
	 * Cleans key value parameter.
	 *
	 * @param array  $field Field data.
	 * @param string $name  Parameter name.
	 */
	protected function clean_key_value_data( &$field, $name ) {
		if ( empty( $field[ $name ] ) || ! is_array( $field[ $name ] ) ) {
			$field[ $name ] = array();
			return;
		}

		foreach ( $field[ $name ] as $index => $value ) {
			if ( empty( $value['key'] ) ) {
				unset( $field[ $name ][ $index ] );
			}
		}
	}

	/**
	 * Normalizes default of image field.
	 *
	 * @param array $field Field data.
	 */
	protected function normalize_image_default( &$field ) {
		if ( 'image' !== $field['type'] ) {
			return;
		}

		if ( empty( $field['default'] ) ) {
			return;
		}

		if ( is_numeric( $field['default'] ) ) {
			$field['default'] = array(
				'id'  => intval( $field['default'] ),
				'url' => '',
			);
			return;
		}

		$field['default'] = array(
			'id'  => '',
			'url' => esc_url( $field['default'] ),
		);
	}

	/**
	 * Normalizes default of images field.
	 *
	 * @param array $field Field data.
	 */
	protected function normalize_images_default( &$field ) {
		if ( 'images' !== $field['type'] ) {
			return;
		}

		$field['default'] = array();
	}

	/**
	 * Cleans nested fields.
	 *
	 * @param array $field Field data.
	 */
	protected function clean_nested_fields( &$field ) {
		if ( in_array( $field['type'], $this->get_fields_have_nested() ) ) {
			return;
		}

		if ( isset( $field['fields'] ) ) {
			unset( $field['fields'] );
		}
	}

	/**
	 * Cleans tabs.
	 *
	 * @param array $field Field data.
	 */
	protected function clean_tabs( &$field ) {
		if ( 'tab' === $field['type'] ) {
			return;
		}

		if ( isset( $field['tabs'] ) ) {
			unset( $field['tabs'] );
		}
	}

	/**
	 * Normalize field dependency.
	 *
	 * @param array $field Field data.
	 */
	protected function normalize_dependency( &$field ) {
		if ( empty( $field['dependency'] ) || ! is_array( $field['dependency'] ) ) {
			$field['dependency'] = array();
			return;
		}

		foreach ( $field['dependency'] as $index => $rule ) {
			if ( empty( $rule['key'] ) ) {
				unset( $field['dependency'][ $index ] );
				continue;
			}

			if ( empty( $rule['value'] ) ) {
				$field['dependency'][ $index ]['value'] = '';
				continue;
			}

			$field['dependency'][ $index ]['value'] = $this->normalize_dependency_rule_value( $rule['value'] );
		}

		$field['dependency'] = array_values( $field['dependency'] );
	}

	/**
	 * Normalizes dependency rule value.
	 *
	 * @param  string $value Dependency rule value.
	 * @return mixed
	 */
	protected function normalize_dependency_rule_value( $value ) {
		$value = trim( $value );

		if ( '{{{true}}}' === $value ) {
			return true;
		}

		if ( '{{{false}}}' === $value ) {
			return false;
		}

		if ( false === strpos( $value, '|||' ) ) {
			return $value;
		}

		$value = explode( '|||', $value );
		$value = array_map( array( $this, 'normalize_dependency_rule_value' ), $value );

		return $value;
	}

	/**
	 * Gets field types have nested.
	 *
	 * @return array
	 */
	protected function get_fields_have_nested() {
		/**
		 * Filters field types have nested.
		 *
		 * @since 0.3.0
		 *
		 * @param array $types Field types which have nested.
		 */
		return apply_filters( 'puppyfw_fields_have_nested', array( 'group', 'tab' ) );
	}
}
