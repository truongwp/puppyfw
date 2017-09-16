# PuppyFW #

PuppyFW is a powerful options framework for WordPress themes and plugins.

At the moment, this plugin only support option pages. If you want more features like meta boxes, term meta, comment meta, user profile fields, etc., visit [https://metabox.io/](https://metabox.io/), you won't be disappointed.

### Features ###

- Multiple option pages
- Multi-level tabs
- Multi-level groups
- Unlimited repeat fields, works with any fields, any level of tabs and groups
- Field dependency
- Option to save data to separate rows or single row in options table

### Supported fields ###

- text
- email
- tel
- url
- number
- checkbox
- checkbox_list
- radio
- select
- textarea
- image
- images
- map
- editor
- tab
- group
- repeatable

### Installation ###

1. Download from [WordPress plugins repo](https://wordpress.org/plugins/puppyfw/) and install it.

2. Use composer:

```
composer require truongwp\puppyfw=*
```

### Usage ###

[[View full documentation]](https://github.com/truongwp/puppyfw/wiki)

Add the code below to your themes or plugins:

```php
function prefix_register_options( $framework ) {
	$framework->add_page( array(
		'page_title'  => 'PuppyFW',
		'menu_title'  => 'PuppyFW',
		'capability'  => 'manage_options',
		'menu_slug'   => 'puppyfw',
		'option_name' => 'puppyfw_test', // Leave empty if you want to store options to seperate rows.
		'position'    => 100,
		'fields'      => array(
			// Define fields here.
		),
	) );
}
add_action( 'puppyfw_init', 'prefix_register_options' );
```

For defining fields, please see file `puppyfw/demo/demo.php`. You can include that file to view the demo.

If you get any problems when define fields, please create issue or contact me via email [truongwp@gmail.com](mailto:truongwp@gmail.com). I'm working on documentation and will finish it ASAP.

### Contribution ###

**Contributor:** [@truongwp](https://truongwp.com)

To contribute, clone this repo and run `composer dump-autoload`, add your code and create a Pull Request.

Bug reports or Pull requests are welcome.
