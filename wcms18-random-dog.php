<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              thehiveresistance.com
 * @since             1.0.0
 * @package           Wcms18_Random_Dog
 *
 * @wordpress-plugin
 * Plugin Name:       WCMS18 Random Dog
 * Plugin URI:        thehiveresistance.com/wcms18-random-dog
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Johan Nordström
 * Author URI:        thehiveresistance.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wcms18-random-dog
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
define( 'WCMS18_RANDOM_DOG_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wcms18-random-dog-activator.php
 */
function activate_wcms18_random_dog() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wcms18-random-dog-activator.php';
	Wcms18_Random_Dog_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wcms18-random-dog-deactivator.php
 */
function deactivate_wcms18_random_dog() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wcms18-random-dog-deactivator.php';
	Wcms18_Random_Dog_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wcms18_random_dog' );
register_deactivation_hook( __FILE__, 'deactivate_wcms18_random_dog' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wcms18-random-dog.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wcms18_random_dog() {

	$plugin = new Wcms18_Random_Dog();
	$plugin->run();

}
run_wcms18_random_dog();
