<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.expresstechsoftwares.com
 * @since             1.0.0
 * @package           Lifterlms_Discord_Addon
 *
 * @wordpress-plugin
 * Plugin Name:       LifterLMS Discord AddOn
 * Plugin URI:        https://www.expresstechsoftwares.com/?page_id=18295&preview=true
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            ExpressTech Softwares Solutions Pvt Ltd
 * Author URI:        https://www.expresstechsoftwares.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lifterlms-discord-addon
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
define( 'LIFTERLMS_DISCORD_ADDON_VERSION', '1.0.0' );

define('LIFTERLMS_PLUGIN_DIR',plugin_dir_path(__FILE__));
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lifterlms-discord-addon-activator.php
 */
function activate_lifterlms_discord_addon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lifterlms-discord-addon-activator.php';
	Lifterlms_Discord_Addon_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lifterlms-discord-addon-deactivator.php
 */
function deactivate_lifterlms_discord_addon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lifterlms-discord-addon-deactivator.php';
	Lifterlms_Discord_Addon_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lifterlms_discord_addon' );
register_deactivation_hook( __FILE__, 'deactivate_lifterlms_discord_addon' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lifterlms-discord-addon.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lifterlms_discord_addon() {

	$plugin = new Lifterlms_Discord_Addon();
	$plugin->run();

}
run_lifterlms_discord_addon();
