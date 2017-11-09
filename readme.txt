=== PuppyFW ===
Contributors: truongwp
Donate link: https://www.paypal.me/truongwp
Tags: framework, theme-options, theme-framework, plugin-framework, theme-settings
Requires at least: 4.8
Requires PHP: 5.3
Tested up to: 4.9-RC2
Stable tag: 0.4.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

PuppyFW is a lightweight but powerful options framework for WordPress themes and plugins which supports tab, group, repeatable, field dependencies. It comes with Options Page Builder so doesn't require coding skills to use.

== Description ==

This plugin allows you add options pages simply via Options Page Builder. It's free but supports premium features: tab, group field, repeatable field, field dependencies. It's powerful but lightweight and fast.

Beside built-in fields, PuppyFW also allows you can create your own fields easily.

Checkout the short video below to have a first look about this plugin:

https://youtu.be/6Ae819U1phI

= More Information =

* For help use [wordpress.org](http://wordpress.org/support/plugin/puppyfw/) or create issues on [Github](https://github.com/truongwp/puppyfw/)
* Fork or contribute on [Github](https://github.com/truongwp/puppyfw/)
* Visit [my website](https://truongwp.com/)
* View my other [WordPress Plugins](http://profiles.wordpress.org/truongwp/)

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/puppyfw` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to `Options pages > Add New` to add an options page.
4. Follow [the documentation](https://truongwp.blog/puppyfw-documentation/) for more detail.

== Frequently Asked Questions ==

= Does it support nested tabs =

Yes, it supports multi-level nested tabs.

= Can repeatable field woth with group, editor? =

Yes, repeatable field can work with any fields.

= Can group field be sortable and collapsible? =

At the moment, it can't. But they will be supported in the future.

== Screenshots ==

1. Basic fields
2. WordPress fields
3. Advanced fields

== Changelog ==

= 0.4.0 =
- Support media buttons in editor field (requires WordPress 4.9)
- Added import/export feature for options page builder
- Hook `puppyfw_builder_assets`
- Show options page data in posts list table
- Removed `PUPPYFW_VERSION` constant
- Check the existing of function `puppyfw()` to load plugin instead of `PUPPYFW_VERSION` constant which be removed

= 0.3.0 =
* First release

== Upgrade Notice ==

No information yet.
