<?php
/**
 * Abstract field class
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

use PuppyFW\FieldFactory;
use PuppyFW\Helpers;
use PuppyFW\StaticCache;
use PuppyFW\Page;

/**
 * Class Field
 */
abstract class Field {

	/**
	 * Field data.
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Class Field construct.
	 *
	 * @param array $field_data Field data.
	 */
	public function __construct( $field_data ) {
		$field_data = $this->normalize( $field_data );
		$this->data = apply_filters( 'puppyfw_normalize_field_data', $field_data, $this );
	}

	/**
	 * Normalize field data.
	 *
	 * @param  array $field_data Field data.
	 * @return array
	 */
	protected function normalize( $field_data ) {
		$field_data = wp_parse_args( $field_data, array(
			'id'          => '',
			'title'       => '',
			'desc'        => '',
			'type'        => 'input',
			'position'    => 0,
			'sortable'    => false,
			'collapsible' => false,
			'default'     => null,
			'attrs'       => array(),
			'options'     => array(),
			'visible'     => true,
			'value'       => null,
			'option_name' => '',
		) );

		$field_data['id_attr'] = 'puppyfw-' . $field_data['id'];

		/**
		 * Filters field value.
		 *
		 * @since 0.1.0
		 *
		 * @param mixed $value      Field value.
		 * @param array $field_data Field data.
		 */
		$field_data['value'] = apply_filters( 'puppyfw_get_field_value', $this->get_value( $field_data ), $field_data );

		return $field_data;
	}

	/**
	 * Gets field value. Only support first level field.
	 *
	 * @param  array $field_data Field data.
	 * @return mixed
	 */
	protected function get_value( $field_data ) {
		if ( in_array( $field_data['type'], array( 'tab', 'section' ) ) ) {
			return null;
		}

		if ( ! $field_data['option_name'] ) {
			return get_option( $field_data['id'], $field_data['default'] );
		}

		$options = StaticCache::get( $field_data['option_name'] );
		if ( is_null( $options ) ) {
			$options = get_option( $field_data['option_name'] );
			StaticCache::set( $field_data['option_name'], $options );
		}

		if ( isset( $options[ $field_data['id'] ] ) ) {
			return $options[ $field_data['id'] ];
		}

		if ( isset( $field_data['default'] ) ) {
			return $field_data['default'];
		}

		return null;
	}

	/**
	 * Field render.
	 */
	public function render() {
		// Don't print template for used field types.
		$mapped_type = Helpers::get_mapped_type( $this->data['type'] );
		if ( ! in_array( $mapped_type, Page::$used_field_types ) ) {
			add_action( 'admin_footer', array( $this, 'js_template' ) );
			Page::$used_field_types[] = $mapped_type;
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	/**
	 * Enqueues styles and scripts.
	 */
	public function enqueue() {}

	/**
	 * Converts field to array.
	 * This method will be called recursive.
	 *
	 * @return array
	 */
	public function to_array() {
		$data = $this->data;
		$this->render();

		if ( ! empty( $this->data['fields'] ) && is_array( $this->data['fields'] ) ) {
			$fields = array();

			foreach ( $this->data['fields'] as $field ) {
				$field['option_name'] = $this->data['option_name'];
				$field = FieldFactory::get_field( $field );
				$fields[] = $field->to_array();
			}

			$data['fields'] = $fields;
		}

		return $data;
	}

	/**
	 * Render js template.
	 */
	abstract public function js_template();
}
