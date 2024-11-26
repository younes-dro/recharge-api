<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://github.com/younes-dro
 * @since             1.0.0
 * @package           Recharge_Api
 *
 * @wordpress-plugin
 * Plugin Name:       Recharge API
 * Plugin URI:        https://https://stargps.ma/
 * Description:       Sending internet recharge for GPS Tracker by API
 * Version:           1.0.0
 * Author:            Younes DRO
 * Author URI:        https://https://github.com/younes-dro
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       recharge-api
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
define( 'RECHARGE_API_VERSION', '1.0.0' );
define( 'RECHARGE_API_BASENAME', plugin_basename( __FILE__ ) );

// define( 'RECHARGE_API_ROOTFILE', __FILE__ );

define( 'RECHARGE_API_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'RECHARGE_API_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-recharge-api-activator.php
 */
function activate_recharge_api() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-recharge-api-activator.php';
	Recharge_Api_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-recharge-api-deactivator.php
 */
function deactivate_recharge_api() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-recharge-api-deactivator.php';
	Recharge_Api_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_recharge_api' );
register_deactivation_hook( __FILE__, 'deactivate_recharge_api' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-recharge-api.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_recharge_api() {

	$plugin = new Recharge_Api();
	$plugin->run();

}
run_recharge_api();
