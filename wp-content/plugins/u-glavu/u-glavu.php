<?php

namespace UGlavu;

use DI\Container;
use UGlavu\Includes\UGlavu;
use UGlavu\Includes\UGlavuActivator;
use UGlavu\Includes\UGlavuDeactivator;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://uglavu.com
 * @since             1.0.0
 * @package           U_Glavu
 *
 * @wordpress-plugin
 * Plugin Name:       U Glavu
 * Plugin URI:        https://uglavu.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            U Glavu
 * Author URI:        https://uglavu.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       u-glavu
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'U_GLAVU_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-u-glavu-activator.php
 */
function activate_u_glavu() {
	UGlavuActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-u-glavu-deactivator.php
 */
function deactivate_u_glavu() {
	UGlavuDeactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_u_glavu' );
register_deactivation_hook( __FILE__, 'deactivate_u_glavu' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-u-glavu.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_u_glavu() {

    $container = getContainer();
	$plugin = $container->get(UGlavu::class);
	$plugin->run();
}
run_u_glavu();


function getContainer()
{
    $container = new Container();
    return $container;
}