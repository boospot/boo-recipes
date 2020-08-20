<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://boospot.com
 * @since             1.0.0
 * @package           Boorecipe
 *
 * @wordpress-plugin
 * Plugin Name:       Boo Recipes
 * Plugin URI:        http://boorecipes.com/
 * Description:       Easily add Recipes in user friendly way that generates SEO optimized recipes using Schema.org microdata.
 * Version:           2.3.0
 * Author:            BooSpot Team
 * Author URI:        https://boospot.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       boo-recipes
 * Domain Path:       /languages
 */

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Plugin base dir path.
 * used to locate plugin resources primarily code files
 * Start at version 1.0.0
 */
define( 'BOORECIPE_BASE_DIR', plugin_dir_path( __FILE__ ) );


/**
 * Plugin url to access its resources through browser
 * used to access assets images/css/js files
 * Start at version 1.0.0
 */
define( 'BOORECIPE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Currently plugin version.
 * Start at version 1.0.0
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BOORECIPE_VERSION', '2.3.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-boorecipe-activator.php
 */
function activate_boorecipe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-boorecipe-activator.php';
	Boorecipe_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-boorecipe-deactivator.php
 */
function deactivate_boorecipe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-boorecipe-deactivator.php';
	Boorecipe_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_boorecipe' );
register_deactivation_hook( __FILE__, 'deactivate_boorecipe' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-boorecipe.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_boorecipe() {

	$plugin = new Boorecipe();
	$plugin->run();

}

run_boorecipe();