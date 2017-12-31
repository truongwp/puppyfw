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
	 * Check if this field has value. Eg: tab, html don't have value.
	 *
	 * @var bool
	 */
	protected $has_value = true;

	/**
	 * Field data.
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Page instance.
	 *
	 * @var Page
	 */
	protected $page;

	/**
	 * Child fields.
	 *
	 * @var array
	 */
	protected $fields = array();

	/**
	 * Class Field construct.
	 *
	 * @param array $field_data Field data.
	 */
	public function __construct( $field_data ) {
		$this->page = $field_data['page'];
		unset( $field_data['page'] );

		// Store default value.
		if ( $this->has_value() && isset( $field_data['default'] ) && ! is_null( $field_data['default'] ) ) {
			$this->page->add_default( $field_data['id'], $field_data['default'] );
		}

		// Support old defining fields method.
		if ( ! empty( $field_data['fields'] ) ) {
			foreach ( $field_data['fields'] as $field ) {
				$this->add_field( $field );
			}
			unset( $field_data['fields'] );
		}

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

		if ( $this->has_value ) {
			/**
			 * Filters field value.
			 *
			 * @since 0.1.0
			 *
			 * @param mixed $value      Field value.
			 * @param array $field_data Field data.
			 */
			$field_data['value'] = apply_filters( 'puppyfw_get_field_value', $this->get_value( $field_data ), $field_data );
		}

		return $field_data;
	}

	/**
	 * Adds child field.
	 *
	 * @param array $field_data Field data.
	 * @return Field Field instance.
	 */
	public function add_field( $field_data ) {
		$field_data['page'] = $this->page;
		$field = FieldFactory::get_field( $field_data );

		// Add field.
		$this->fields[] = $field;

		return $field;
	}

	/**
	 * Gets field data.
	 *
	 * @param  string $key Data key.
	 * @return mixed
	 */
	public function get( $key ) {
		if ( isset( $this->data[ $key ] ) ) {
			return $this->data[ $key ];
		}
		return null;
	}

	/**
	 * Gets page instance.
	 *
	 * @return Page
	 */
	public function get_page() {
		return $this->page;
	}

	/**
	 * Checks if this field has value.
	 *
	 * @return bool
	 */
	public function has_value() {
		return $this->has_value;
	}

	/**
	 * Gets field value. Only support first level field.
	 * This method is called when normalizing so we must passed field data.
	 *
	 * @param  array $field_data Field data.
	 * @return mixed
	 */
	protected function get_value( $field_data ) {
		if ( $this->has_value ) {
			return $this->page->get_option( $field_data['id'] );
		}
		return null;
	}

	/**
	 * Field render.
	 */
	public function render() {
		// Don't print template for rendered field types.
		$mapped_type = puppyfw()->helper->get_mapped_type( $this->data['type'] );
		$rendered_fields = StaticCache::get( 'rendered_fields' );

		if ( ! in_array( $mapped_type, $rendered_fields ) ) {
			add_action( 'admin_footer', array( $this, 'js_template' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

			$rendered_fields[] = $mapped_type;
			StaticCache::set( 'rendered_fields', $rendered_fields );
		}
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
		$this->render();
		$data = $this->data;

		if ( $this->fields ) {
			$fields = array();
			foreach ( $this->fields as $field ) {
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
