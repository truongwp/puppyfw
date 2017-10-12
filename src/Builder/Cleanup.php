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
			$this->clean_js_options( $field );
			$this->normalize_image_default( $field );
			$this->normalize_images_default( $field );

			if ( ! empty( $field['fields'] ) ) {
				$field['fields'] = $this->clean( $field['fields'] );
			}

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

	/**
	 * Cleans js options parameter.
	 *
	 * @param array $field Field data.
	 */
	protected function clean_js_options( &$field ) {
		$js_options = array();
		$field['js_options'] = isset( $field['js_options'] ) ? (array) $field['js_options'] : array();
		foreach ( $field['js_options'] as $attr ) {
			if ( ! empty( $attr['key'] ) ) {
				$js_options[ $attr['key'] ] = $attr['value'];
			}
		}
		$field['js_options'] = $js_options;
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
}
