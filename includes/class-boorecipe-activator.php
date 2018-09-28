<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// if class already defined, bail out
if ( class_exists( 'Boorecipe_Activator' ) ) {
	return;
}

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Boorecipe
 * @subpackage Boorecipe/includes
 * @author     Rao Abid <raoabid491@gmail.com>
 */
class Boorecipe_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Set Default Options
		self::set_default_options();


		/**
		 * Custom Post Types
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-boorecipe-custom_posts.php';
		$plugin_post_types = new Boorecipe_Post_Types();

		/**
		 * The problem with the initial activation code is that when the activation hook runs, it's after the init hook has run,
		 * so hooking into init from the activation hook won't do anything.
		 * You don't need to register the CPT within the activation function unless you need rewrite rules to be added
		 * via flush_rewrite_rules() on activation. In that case, you'll want to register the CPT normally, via the
		 * loader on the init hook, and also re-register it within the activation function and
		 * call flush_rewrite_rules() to add the CPT rewrite rules.
		 *
		 * @link https://github.com/DevinVinson/WordPress-Plugin-Boilerplate/issues/261
		 */
		$plugin_post_types->create_custom_post_type();

		/**
		 * This only required if custom post type has rewrite!
		 *
		 * Remove rewrite rules and then recreate rewrite rules.
		 *
		 * This function is useful when used with custom post types as it allows for automatic flushing of the WordPress
		 * rewrite rules (usually needs to be done manually for new custom post types).
		 * However, this is an expensive operation so it should only be used when absolutely necessary.
		 * See Usage section for more details.
		 *
		 * Flushing the rewrite rules is an expensive operation, there are tutorials and examples that suggest
		 * executing it on the 'init' hook. This is bad practice. It should be executed either
		 * on the 'shutdown' hook, or on plugin/theme (de)activation.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/flush_rewrite_rules
		 */
		flush_rewrite_rules();

	}

	/**
	 *  sets default options settings for plugin.
	 */
	public static function set_default_options() {

		if ( ! get_option( 'boorecipe-options' ) ) {

			require_once BOORECIPE_BASE_DIR . 'includes/class-boorecipe-global-functions.php';

			$plugin_global = new Boorecipe_Globals( 'boorecipe', '1.0.0' );

			$plugin_default_options = $plugin_global::get_default_options_array();


			if ( is_array( $plugin_default_options ) && ! empty( $plugin_default_options ) ) {
				add_option( 'boorecipe-options', $plugin_default_options );
			}


		}
	}

}
