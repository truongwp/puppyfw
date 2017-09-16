<?php
/**
 * Choice field class
 * Fields contain `options` parameter should extend this class.
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Class Choice
 */
abstract class Choice extends Field {

	/**
	 * Normalize field data.
	 *
	 * @param  array $field_data Field data.
	 * @return array
	 */
	protected function normalize( $field_data ) {
		$field_data = parent::normalize( $field_data );

		if ( ! isset( $field_data['data_source'] ) ) {
			$field_data['data_source'] = '';
		}

		if ( ! isset( $field_data['post_type'] ) ) {
			$field_data['post_type'] = 'post';
		}

		if ( ! isset( $field_data['taxonomy'] ) ) {
			$field_data['taxonomy'] = 'category';
		}

		if ( ! isset( $field_data['none_option'] ) ) {
			$field_data['none_option'] = '';
		}

		$field_data['options'] = $this->parse_options( $field_data );

		return $field_data;
	}

	/**
	 * Parses field options.
	 *
	 * @param  array $field_data Field data.
	 * @return array
	 */
	protected function parse_options( $field_data ) {
		if ( $field_data['data_source'] && is_callable( array( $this, "get_{$field_data['data_source']}_options" ) ) ) {
			$data_source = $field_data['data_source'];
			$options = call_user_func( array( $this, "get_{$data_source}_options" ), $field_data );
			return apply_filters( "puppyfw_field_{$data_source}_options", $options, $field_data );
		}

		if ( ! is_array( reset( $field_data['options'] ) ) ) {
			return $this->transform_options( $field_data['options'] );
		}

		return $field_data['options'];
	}

	/**
	 * Transforms options from key=>value to array( 'key' => key, 'value' => value ).
	 *
	 * @param  array $options Field options.
	 * @return array
	 */
	protected function transform_options( $options ) {
		$new_options = array();

		foreach ( $options as $key => $value ) {
			$new_options[] = compact( 'key', 'value' );
		}

		return $new_options;
	}

	/**
	 * Gets post options.
	 *
	 * @param array $field_data Field data.
	 * @return array
	 */
	protected function get_post_options( $field_data ) {
		$options = array();

		if ( $field_data['none_option'] ) {
			$options[] = array(
				'key'   => '',
				'value' => $field_data['none_option'],
			);
		}

		$posts = get_posts( array(
			'post_type' => $field_data['post_type'],
			'nopaging'  => true,
			'orderby'   => 'title',
			'order'     => 'asc',
		) );

		foreach ( $posts as $post ) {
			$options[] = array(
				'key'   => $post->ID,
				'value' => $post->post_title,
			);
		}

		return $options;
	}

	/**
	 * Gets term options.
	 *
	 * @param array $field_data Field data.
	 * @return array
	 */
	protected function get_term_options( $field_data ) {
		$options = array();

		if ( $field_data['none_option'] ) {
			$options[] = array(
				'key'   => '',
				'value' => $field_data['none_option'],
			);
		}

		$terms = get_terms( array(
			'taxonomy'   => $field_data['taxonomy'],
			'orderby'    => 'name',
			'order'      => 'asc',
			'hide_empty' => false,
		) );

		foreach ( $terms as $term ) {
			$options[] = array(
				'key'   => $term->term_id,
				'value' => $term->name,
			);
		}

		return $options;
	}

	/**
	 * Gets taxonomy options.
	 *
	 * @param array $field_data Field data.
	 * @return array
	 */
	protected function get_taxonomy_options( $field_data ) {
		$options = array();

		if ( $field_data['none_option'] ) {
			$options[] = array(
				'key'   => '',
				'value' => $field_data['none_option'],
			);
		}

		$taxonomies = get_taxonomies();

		foreach ( $taxonomies as $taxonomy ) {
			$options[] = array(
				'key'   => $taxonomy,
				'value' => $taxonomy,
			);
		}

		return $options;
	}
}
