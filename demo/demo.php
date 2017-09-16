<?php
/**
 * Example for simple options
 *
 * @package PuppyFW
 */

/**
 * Register options.
 *
 * @param \PuppyFW\Framework $framework Framework object.
 */
function prefix_register_options_demo( $framework ) {
	$framework->add_page( array(
		'page_title' => 'PuppyFW Demo',
		'menu_title' => 'PuppyFW Demo',
		'capability' => 'manage_options',
		'menu_slug'  => 'puppyfw_demo',
		'option_name' => 'puppyfw_demo',
		'position'   => 100,
		'fields'     => array(
			array(
				'id'      => 'tab',
				'type'    => 'tab',
				'tabs'    => array(
					'simple' => 'Simple fields',
					'wordpress' => 'WordPress fields',
					'advanced' => 'Advanced fields',
					'dependency' => 'Field dependency',
				),
				'fields'  => array(
					array(
						'id'      => 'test_text',
						'title'   => 'Text field',
						'desc'    => 'This is an example text field',
						'default' => 'Default value',
						'type'    => 'text',
						'tab'     => 'simple',
					),
					array(
						'id'      => 'test_email',
						'title'   => 'Email field',
						'default' => 'truongwp@gmail.com',
						'type'    => 'email',
						'tab'     => 'simple',
					),
					array(
						'id'      => 'test_number',
						'title'   => 'Number field',
						'default' => 10,
						'type'    => 'number',
						'tab'     => 'simple',
						'attrs'   => array(
							'min'     => 0,
							'step'    => 2,
							'max'     => 30,
						),
					),
					array(
						'id'      => 'test_tel',
						'title'   => 'Tel field',
						'type'    => 'tel',
						'tab'     => 'simple',
						'attrs'   => array(
							'size' => 15,
						),
					),
					array(
						'id'      => 'test_checkbox',
						'title'   => 'Checkbox field',
						'type'    => 'checkbox',
						'tab'     => 'simple',
						'default' => true,
					),
					array(
						'id'      => 'test_checkbox_list',
						'title'   => 'Checkbox list field',
						'type'    => 'checkbox_list',
						'tab'     => 'simple',
						'default' => array( 2, 3 ),
						'options' => array(
							1 => 'Option 1',
							2 => 'Option 2',
							3 => 'Option 3',
							4 => 'Option 4',
						),
					),
					array(
						'id'      => 'test_radio',
						'title'   => 'Radio field',
						'type'    => 'radio',
						'tab'     => 'simple',
						'inline'  => true,
						'default' => 2,
						'options' => array(
							1 => 'Option 1',
							2 => 'Option 2',
							3 => 'Option 3',
						),
					),
					array(
						'id'      => 'test_select',
						'title'   => 'Select field',
						'type'    => 'select',
						'tab'     => 'simple',
						'default' => 3,
						'options' => array(
							1 => 'Option 1',
							2 => 'Option 2',
							3 => 'Option 3',
							4 => 'Option 4',
						),
					),
					array(
						'id'      => 'test_multiple_select',
						'title'   => 'Multiple select field',
						'type'    => 'select',
						'tab'     => 'simple',
						'multiple' => true,
						'default' => array( 2, 4 ),
						'options' => array(
							1 => 'Option 1',
							2 => 'Option 2',
							3 => 'Option 3',
							4 => 'Option 4',
						),
					),
					array(
						'id'      => 'test_textarea',
						'title'   => 'Textarea field',
						'default' => "Default value\nSupport multiline",
						'type'    => 'textarea',
						'tab'     => 'simple',
					),

					// WordPress fields.
					array(
						'id'    => 'test_page_select',
						'title' => 'Page select',
						'type'  => 'select',
						'tab'   => 'wordpress',
						'data_source' => 'post',
						'post_type'   => 'page',
						'none_option' => 'Choose a page',
					),
					array(
						'id'    => 'test_tags_select',
						'title' => 'Tags select',
						'type'  => 'select',
						'tab'   => 'wordpress',
						'data_source' => 'term',
						'taxonomy'    => 'post_tag',
						'multiple'    => true,
					),
					array(
						'id'    => 'test_taxonomy_select',
						'title' => 'Taxonomy select',
						'type'  => 'checkbox_list',
						'tab'   => 'wordpress',
						'data_source' => 'taxonomy',
					),
					array(
						'id'    => 'test_editor',
						'title' => 'Test editor',
						'type'  => 'editor',
						'tab'   => 'wordpress',
						'tinymce' => true,
					),
					array(
						'id'    => 'test_image',
						'title' => 'Image field',
						'type'  => 'image',
						'tab'   => 'wordpress',
						'default' => array(
							'url' => 'https://assets.merriam-webster.com/mw/images/article/art-wap-article-main/puppy-3143-7cfb4d6a42dfc7d9d1ae7e23126279e8@1x.jpg',
						),
					),
					array(
						'id'    => 'test_images',
						'title' => 'Images field',
						'type'  => 'images',
						'tab'   => 'wordpress',
					),

					// Advanced fields.
					array(
						'id'    => 'test_map',
						'title' => 'Test map',
						'type'  => 'map',
						'tab'   => 'advanced',
					),
					array(
						'id'     => 'test_tab_1',
						'type'   => 'tab',
						'tabs'   => array(
							'tab-1' => 'Tab 1',
							'tab-2' => 'Tab 2',
							'tab-3' => 'Tab 3',
						),
						'tab'    => 'advanced',
						'fields' => array(
							array(
								'id'    => 'test_textarea_2',
								'title' => 'Test textarea 2',
								'type'  => 'textarea',
								'tab'   => 'tab-1',
							),
							array(
								'id'    => 'test_textarea_3',
								'title' => 'Test textarea 3',
								'type'  => 'textarea',
								'tab'   => 'tab-2',
							),
							array(
								'id'    => 'test_textarea_4',
								'title' => 'Test textarea 4',
								'type'  => 'textarea',
								'tab'   => 'tab-3',
							),
						),
					),
					array(
						'id'     => 'test_group',
						'title'  => 'Test group',
						'type'   => 'group',
						'tab'    => 'advanced',
						'fields' => array(
							array(
								'id'    => 'name',
								'title' => 'Name',
								'type'  => 'text',
							),
							array(
								'id'    => 'email',
								'title' => 'Email',
								'type'  => 'text',
							),
							array(
								'id'    => 'nested_group',
								'title' => 'Nested group',
								'type'  => 'group',
								'fields' => array(
									array(
										'id'    => 'test_editor',
										'title' => 'Nested Editor',
										'type'  => 'editor',
										'tinymce' => true,
										'quicktags' => false,
									),
								),
							),
						),
					),
					array(
						'id'                => 'test_repeatable_text',
						'title'             => 'Repeatable text',
						'type'              => 'repeatable',
						'repeat_field_type' => 'text',
						'tab'               => 'advanced',
					),
					array(
						'id'                => 'test_repeatable_group',
						'title'             => 'Repeatable group',
						'type'              => 'repeatable',
						'repeat_field_type' => 'group',
						'tab'               => 'advanced',
						'fields'            => array(
							array(
								'id'    => 'name',
								'title' => 'Name',
								'type'  => 'text',
							),
							array(
								'id'    => 'email',
								'title' => 'Email',
								'type'  => 'text',
							),
							array(
								'id'    => 'nested_group',
								'title' => 'Nested group',
								'type'  => 'group',
								'fields' => array(
									array(
										'id'    => 'test_editor',
										'title' => 'Nested Editor',
										'type'  => 'repeatable',
										'repeat_field_type' => 'editor',
										'tinymce' => true,
										'quicktags' => false,
									),
								),
							),
						),
					),

					// Dependency tab.
					array(
						'id' => 'human',
						'title' => 'Are you a human?',
						'type'  => 'checkbox',
						'tab'   => 'dependency',
					),
					array(
						'id' => 'has_name',
						'title' => 'Do you have a name?',
						'type'  => 'checkbox',
						'tab'   => 'dependency',
						'dependency' => array( 'human', '==', true ),
					),
					array(
						'id' => 'your_name',
						'title' => 'What is your name?',
						'type'  => 'text',
						'tab'   => 'dependency',
						'dependency' => array(
							array( 'human', true ),
							array( 'has_name', true ),
						),
					),
					array(
						'id' => 'skills',
						'title' => 'Your skills?',
						'type'  => 'checkbox_list',
						'tab'   => 'dependency',
						'options' => array(
							'html5'     => 'HTML5',
							'css3'      => 'CSS3',
							'js'        => 'Javascript',
							'wpthemes'  => 'WordPress themes development',
							'wpplugins' => 'WordPress plugins development',
						),
					),
					array(
						'id'         => 'wpusername',
						'title'      => 'Your WordPress username?',
						'type'       => 'text',
						'tab'        => 'dependency',
						'dependency' => array( 'skills', 'CONTAIN', array( 'wpthemes', 'wpplugins' ) ),
					),
				),
			),
		),
	) );
}
add_action( 'puppyfw_init', 'prefix_register_options_demo' );
