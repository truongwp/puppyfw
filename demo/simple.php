<?php
/**
 * Demo for simple field
 *
 * @package PuppyFW
 */

function puppyfw_demo_simple( $framework ) {
	$page = $framework->add_page( array(
		'page_title' => 'PuppyFW Demo',
		'menu_title' => 'PuppyFW Demo',
		'capability' => 'manage_options',
		'menu_slug'  => 'puppyfw_demo_simple',
		'option_name' => 'puppyfw_demo_simple',
		'position'   => 100,
	) );

	$tab = $page->add_field( array(
		'id'   => 'tab',
		'type' => 'tab',
		'tabs' => array(
			'text'   => 'Text fields',
			'choice' => 'Choice fields',
		),
	) );

	$tab->add_field( array(
		'id'      => 'text',
		'title'   => 'Text field',
		'desc'    => 'This is an example text field',
		'default' => 'Default value',
		'type'    => 'text',
		'tab'     => 'text',
	) );

	$tab->add_field( array(
		'id'      => 'email',
		'title'   => 'Email field',
		'default' => 'truongwp@gmail.com',
		'type'    => 'email',
		'tab'     => 'text',
	) );

	$tab->add_field( array(
		'id'      => 'number',
		'title'   => 'Number field',
		'default' => 10,
		'type'    => 'number',
		'tab'     => 'text',
		'attrs'   => array(
			'min'     => 0,
			'step'    => 2,
			'max'     => 30,
		),
	) );

	$tab->add_field( array(
		'id'      => 'tel',
		'title'   => 'Tel field',
		'type'    => 'tel',
		'tab'     => 'text',
		'attrs'   => array(
			'size' => 15,
		),
	) );

	$tab->add_field( array(
		'id'      => 'test_textarea',
		'title'   => 'Textarea field',
		'default' => "Default value\nSupport multiline",
		'type'    => 'textarea',
		'tab'     => 'text',
	) );

	$tab->add_field( array(
		'id'      => 'test_checkbox',
		'title'   => 'Checkbox field',
		'type'    => 'checkbox',
		'tab'     => 'choice',
		'default' => true,
	) );
	$tab->add_field( array(
		'id'      => 'test_checkbox_list',
		'title'   => 'Checkbox list field',
		'type'    => 'checkbox_list',
		'tab'     => 'choice',
		'default' => array( 2, 3 ),
		'options' => array(
			1 => 'Option 1',
			2 => 'Option 2',
			3 => 'Option 3',
			4 => 'Option 4',
		),
	) );
	$tab->add_field( array(
		'id'      => 'test_radio',
		'title'   => 'Radio field',
		'type'    => 'radio',
		'tab'     => 'choice',
		'inline'  => true,
		'default' => 2,
		'options' => array(
			1 => 'Option 1',
			2 => 'Option 2',
			3 => 'Option 3',
		),
	) );
	$tab->add_field( array(
		'id'      => 'test_select',
		'title'   => 'Select field',
		'type'    => 'select',
		'tab'     => 'choice',
		'default' => 3,
		'options' => array(
			1 => 'Option 1',
			2 => 'Option 2',
			3 => 'Option 3',
			4 => 'Option 4',
		),
	) );
	$tab->add_field( array(
		'id'      => 'test_multiple_select',
		'title'   => 'Multiple select field',
		'type'    => 'select',
		'tab'     => 'choice',
		'multiple' => true,
		'default' => array( 2, 4 ),
		'options' => array(
			1 => 'Option 1',
			2 => 'Option 2',
			3 => 'Option 3',
			4 => 'Option 4',
		),
	) );
}
add_action( 'puppyfw_init', 'puppyfw_demo_simple' );
