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
}
add_action( 'puppyfw_init', 'puppyfw_demo_simple' );
