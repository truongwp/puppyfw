# PuppyFW #

PuppyFW is a powerful options framework for WordPress themes and plugins.

At the moment, this plugin only support option pages. If you want more features like meta boxes, term meta, comment meta, user profile fields, etc., visit [https://metabox.io/](https://metabox.io/), you won't be disappointed.

## Features

- Multiple option pages
- Multi-level tabs
- Multi-level groups
- Unlimited repeat fields, works with any fields, any level of tabs and groups
- Field dependencies
- Option to save data to separate rows or single row in options table

## Supported fields

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

Checkout the short video below to have a first look about this plugin:

[https://youtu.be/b7g5cdUrT9s](https://youtu.be/b7g5cdUrT9s)

## Installation

### Manually install

**Step 1:** Download stable version [here](https://truongwp.blog/puppyfw.zip).

**Step 2:** Upload and install as a WordPress plugin.
- If you want to use PuppyFW in your plugins, include file `puppyfw/puppyfw.php`.
- If you want to use PuppyFW in your themes, include file `puppyfw/theme-loader.php` and remember to change two path constants.

### Install via composer

Run following command to add PuppyFW to your plugins or themes:
```
composer require truongwp/puppyfw=*
```

### Install from Github repo

**Step 1:** Download or checkout this repo.

**Step 2:** Move to `puppyfw/` folder and run following command:
```
composer dump-autoload
```
**Step 3:** Do step 2 from **Manually install** section.

## Usage

[[View full documentation]](https://github.com/truongwp/puppyfw/wiki) (*Work in process*)

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


For defining fields, please read [Defining fields](https://github.com/truongwp/puppyfw/wiki/Defining-fields) or look at file `puppyfw/demo/demo.php`.

If you get any problems when define fields, please create issue or contact me via email [truongwp@gmail.com](mailto:truongwp@gmail.com). I'm working on documentation and will finish it ASAP.

## Contribution

**Contributor:** [truongwp](https://truongwp.com)

Bug reports or Pull requests are welcome.
