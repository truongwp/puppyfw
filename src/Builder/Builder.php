<?php
/**
 * Options builder
 *
 * @package PuppyFW\Builder
 */

namespace PuppyFW\Builder;

use PuppyFW\Framework;

/**
 * Class Builder
 */
class Builder {

	/**
	 * Class init.
	 */
	public function init() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'puppyfw_init', array( $this, 'register_pages' ), 0 );
		add_action( 'puppyfw_i18n', array( $this, 'register_i18n' ) );

		if ( is_admin() ) {
			$page_meta_box = new PageMetaBox();
			$page_meta_box->init();

			$builder_meta_box = new BuilderMetaBox();
			$builder_meta_box->init();

			$controls = new Controls();
			$controls->init();

			$fields = new Fields();
			$fields->init();
		}
	}

	/**
	 * Registers post type.
	 */
	public function register_post_type() {
		$labels = array(
			'name'               => __( 'Options pages', 'puppyfw' ),
			'singular_name'      => __( 'Options page', 'puppyfw' ),
			'add_new'            => _x( 'Add New', 'puppyfw', 'puppyfw' ),
			'add_new_item'       => __( 'Add New Options page', 'puppyfw' ),
			'edit_item'          => __( 'Edit Options page', 'puppyfw' ),
			'new_item'           => __( 'New Options page', 'puppyfw' ),
			'view_item'          => __( 'View Options page', 'puppyfw' ),
			'search_items'       => __( 'Search Options pages', 'puppyfw' ),
			'not_found'          => __( 'No Options pages found', 'puppyfw' ),
			'not_found_in_trash' => __( 'No Options pages found in Trash', 'puppyfw' ),
			'parent_item_colon'  => __( 'Parent Options page:', 'puppyfw' ),
			'menu_name'          => __( 'Options pages', 'puppyfw' ),
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => __( 'PuppyFW options page', 'puppyfw' ),
			'taxonomies'          => array(),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => false,
			'menu_position'       => null,
			'menu_icon'           => null,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => false,
			'can_export'          => true,
			'rewrite'             => false,
			'capability_type'     => 'post',
			'supports'            => array( 'title' ),
		);

		register_post_type( 'puppyfw_page', $args );
	}

	/**
	 * Registers options pages.
	 *
	 * @param Framework $framework Framework instance.
	 */
	public function register_pages( Framework $framework ) {
		$posts = get_posts( array(
			'post_type' => 'puppyfw_page',
			'nopaging'  => true,
		) );

		foreach ( $posts as $post ) {
			$page_data = $post->post_excerpt ? json_decode( $post->post_excerpt, true ) : array();
			$page_data['fields'] = $post->post_content ? json_decode( $post->post_content, true ) : array();

			$framework->add_page( $page_data );
		}
	}

	/**
	 * Registers i18n strings.
	 *
	 * @param  array $i18n I18n strings.
	 * @return array
	 */
	public function register_i18n( $i18n ) {
		$i18n['builder'] = array(
			'types'  => array(
				'checkbox'     => _x( 'Checkbox', 'field type', 'puppyfw' ),
				'checkboxList' => _x( 'Checkbox list', 'field type', 'puppyfw' ),
				'colorpicker'  => _x( 'Colorpicker', 'field type', 'puppyfw' ),
				'datepicker'   => _x( 'Datepicker', 'field type', 'puppyfw' ),
				'editor'       => _x( 'Editor', 'field type', 'puppyfw' ),
				'email'        => _x( 'Email', 'field type', 'puppyfw' ),
				'group'        => _x( 'Group', 'field type', 'puppyfw' ),
				'html'         => _x( 'Html', 'field type', 'puppyfw' ),
				'image'        => _x( 'Image', 'field type', 'puppyfw' ),
				'images'       => _x( 'Images', 'field type', 'puppyfw' ),
				'map'          => _x( 'Map', 'field type', 'puppyfw' ),
				'number'       => _x( 'Number', 'field type', 'puppyfw' ),
				'radio'        => _x( 'Radio', 'field type', 'puppyfw' ),
				'select'       => _x( 'Select', 'field type', 'puppyfw' ),
				'tab'          => _x( 'Tab', 'field type', 'puppyfw' ),
				'tel'          => _x( 'Tel', 'field type', 'puppyfw' ),
				'text'         => _x( 'Text', 'field type', 'puppyfw' ),
			),
			'labels' => array(
				'id'          => _x( 'Field ID', 'field setting label', 'puppyfw' ),
				'title'       => _x( 'Field title', 'field setting label', 'puppyfw' ),
				'description' => _x( 'Field description', 'field setting label', 'puppyfw' ),
				'type'        => _x( 'Field type', 'field setting label', 'puppyfw' ),
				'attributes'  => _x( 'Field attributes', 'field setting label', 'puppyfw' ),
				'default'     => _x( 'Default', 'field setting label', 'puppyfw' ),
				'options'     => _x( 'Options', 'field setting label', 'puppyfw' ),
				'tabs'        => _x( 'Tabs', 'field setting label', 'puppyfw' ),
				'tab'         => _x( 'Tab', 'field setting label', 'puppyfw' ),
				'jsOptions'   => _x( 'Javascript Options', 'field setting label', 'puppyfw' ),
				'quicktags'   => _x( 'Quicktags', 'field setting label', 'puppyfw' ),
				'tinymce'     => _x( 'Tinymce', 'field setting label', 'puppyfw' ),
				'fields'      => _x( 'Fields', 'field setting label', 'puppyfw' ),
				'content'     => _x( 'Content', 'field setting label', 'puppyfw' ),
				'key'         => _x( 'Key', 'field setting label', 'puppyfw' ),
				'value'       => _x( 'Value', 'field setting label', 'puppyfw' ),
				'remove'      => _x( 'Remove', 'field setting label', 'puppyfw' ),
				'addAttribute' => _x( '+ Add attribute', 'field setting label', 'puppyfw' ),
				'addOption'    => _x( '+ Add option', 'field setting label', 'puppyfw' ),
				'addTab'       => _x( '+ Add tab', 'field setting label', 'puppyfw' ),
				'inline'       => _x( 'Inline', 'field setting label', 'puppyfw' ),
				'dataSource'   => _x( 'Data source', 'field setting label', 'puppyfw' ),
				'post'         => _x( 'Post', 'field setting label', 'puppyfw' ),
				'postType'     => _x( 'Post type', 'field setting label', 'puppyfw' ),
				'term'         => _x( 'Term', 'field setting label', 'puppyfw' ),
				'taxonomy'     => _x( 'Taxonomy', 'field setting label', 'puppyfw' ),
				'noneOption'   => _x( 'None option', 'field setting label', 'puppyfw' ),
			),
		);

		return $i18n;
	}
}
