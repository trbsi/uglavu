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

1.5.3: 2019-10-02
- Fix: Properly access global classes inside namespace

1.5.2: 2019-10-01
- New: Clear cache on theme and plugin update
- New: Add shadow for Mailchimp form
- Improvement: Change class of the panel

1.5.1: 2019-09-24
- Improvement: Better animations for quick view modal

1.5.0: 2019-09-20
- New: Compatibility with Blocksy 1.5.0
- Improvement: Better handling for social icons
- Improvement: Support for responsive color picker

1.1.8: 2019-08-20
* Fix: Remove Google+ social network
* Fix: Scripts loading order, makes sure `ct-events` are always present

1.1.7: 2019-08-12
* New: Mailchimp extension customizable placeholders for fields
* Improvement: Use only one translation domain

1.1.6: 2019-08-05
* Improvement: Move user meta social networks from theme
* Fix: Small fixes in styles

1.1.5: 2019-08-01
* New: Option for changing cookies consent on forms
* Fix: `blocksy_get_colors()` call with proper defaults
* Fix: Do not focus on quantity field on quick view open
* Fix: Initialize quick view on infinite scroll load

1.1.4: 2019-07-15
* Fix: Quick view UI when not in Shop
* Fix: Cookie Notice readme for WP Fastest Cache

1.1.3: 2019-07-10
* Fix: Demo install process avoid notices

1.1.2: 2019-07-05
* Improvement: Add RSS social network to About me
* Fix: About me widget socials

1.1.1: 2019-06-30
* Fix: Proper capabilities check for extensions API

1.1.0: 2019-06-27
* New: Demo Install Engine

1.0.11: 2019-06-18
* New: Author widget
* New: Quote widget
* New: About me widget
* New: Facebook Like box widget
* Improvement: Highlight Blocksy widgets and reorder
* Improvement: Shorten Instagram transients period
* Improvement: Instagram add clear caches button
* Improvement: Type option on posts widget

1.0.10: 2019-06-05
* Improvement: Dashboard visual changes
* Fix: Properly enqueue Elementor CSS
* Fix: Instagram images glitch when lazy load is disabled

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
