<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 *
 * Plugin Name:       AlphaSys Content Management
 * Plugin URI:        https://alphasys.com.au
 * Description:       This plugin offers a proper way to easily manage the contents of a page, give an option to set a date availability of a post and manage any external post together with the post of the website.
 * Version:           1.2.0
 * Author:            AlphaSys Pty. Ltd. 
 * Author URI:        https://alphasys.com.au
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       alphasys-content-management
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ASCM_VERSION', '1.0.0.1' );

/*
 * The code that runs during plugin activation.
 * This action is documented in includes/class-alphasys-content-management-activator.php
 */
function activate_alphasys_content_management() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-alphasys-content-management-activator.php';
	Alphasys_Content_Management_Activator::activate();
}

/*
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-alphasys-content-management-deactivator.php
 */
function deactivate_alphasys_content_management() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-alphasys-content-management-deactivator.php';
	Alphasys_Content_Management_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_alphasys_content_management' );
register_deactivation_hook( __FILE__, 'deactivate_alphasys_content_management' );

/*
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-alphasys-content-management.php';

/*
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_alphasys_content_management() {

	$plugin = new Alphasys_Content_Management();
	$plugin->run();

}
run_alphasys_content_management();
