=== Blocksy Companion ===
Tags: widget, widgets
Requires at least: 5.2
Requires PHP: 7.0
Tested up to: 5.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Blocksy Companion adds the extensions system to the Blocksy dashboard and introduces the Instagram extension.

This plugin runs and adds its enhacements only if the Blocksy theme is installed and active.

= Minimum Requirements =

* WordPress 5.0 or greater
* PHP version 7.0 or greater

== Installation ==

1. Upload `Blocksy-Companion-version_number.zip` to the `/wp-content/plugins/` directory and extract.
2. Activate the plugin by going to **Plugins** page in WordPress admin and clicking on **Activate** link.

== Changelog ==

1.0.9: 2019-05-23
* New: Introduce a way for extensions to run code on activation and deactivation
* Improvement: Cookie notification integration with W3 Total Cache, WP Super Cache and WP Rocket
* Improvement: Better way to translate content in JSX
* Fix: Jetpack and Gutenberg interfering with `print_footer_scripts` hook

1.0.8: 2019-05-20
* New: WooCommerce Extra extension with Quick View button for products
* New: Add changelog for companion plugin in dashboard
* Improvement: Disable Read Progress Bar from pages
* Improvement: Improve readme.txt output for plugin updates

1.0.7: 2019-05-11
* Improvement: Move Mailchimp in footer

1.0.6: 2019-05-11
* Improvement: Use WP's global React and ReactDOM
* Improvement: Include gulpfile.js and package.json files in the final build

1.0.5: 2019-05-10
* New: EDD Integration

1.0.4: 2019-05-09
* Fix: Read progress bar check for els presence
* Fix: Small fixes for Instagram block
* Fix: Proper lazy load attributes for sync logic

1.0.3: 2019-05-02
* New: Checkbox for consent
* Improvement: Tested with WordPress 5.2
* Improvement: Support Blocksy child themes variations

1.0.2: 2019-05-01
* New: Google Analytics script
* New: Instagram extension with block and widget
* New: Allow SVG uploads
* New: Read Progress extension
* New: Mailchimp subscribe extension
* New: Cookies consent extension
* New: Elementor Columns Fix switch

1.0.1: 2019-04-11
* Improvement: Instagram widget text & defaults changes
* Fix: Remove `gz` files from build

1.0.0: 2019-04-10
* New: Initial Release
