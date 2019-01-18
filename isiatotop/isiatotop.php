<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/vurghus-minar
 * @since             1.0.0
 * @package           Isiatotop
 *
 * @wordpress-plugin
 * Plugin Name:       isiaToTop
 * Plugin URI:        https://github.com/vurghus-minar/WP-isiaToTop
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Vurghus Minar
 * Author URI:        https://github.com/vurghus-minar
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       isiatotop
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-isiatotop-activator.php
 */
function activate_isiatotop() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-isiatotop-activator.php';
	Isiatotop_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-isiatotop-deactivator.php
 */
function deactivate_isiatotop() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-isiatotop-deactivator.php';
	Isiatotop_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_isiatotop' );
register_deactivation_hook( __FILE__, 'deactivate_isiatotop' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-isiatotop.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_isiatotop() {

	$plugin = new Isiatotop();
	$plugin->run();

}
run_isiatotop();
