<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Premium_Activator' ) ) {
	return;
}

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Boorecipe_Premium
 * @subpackage Boorecipe_Premium/includes
 * @author     Rao Abid <raoabid491@gmail.com>
 */
class Boorecipe_Premium_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		self::create_premium_taxonomies();


	} // activate


	/*
	 * Create Premium taxonomies at activation as well
	 * to avoid 404 on new taxonomy slugs
	 *
	 * remember to do flush_rewrite_rules() after creating new taxonomies
	 */
	public static function create_premium_taxonomies() {

		/*
		 * Require Post Type parent Class
		 * For unified plugin, the parent class is in the same plugin
		 */
		require_once BOORECIPE_BASE_DIR . 'includes/class-boorecipe-custom_posts.php';
		$plugin_post_types = new Boorecipe_Post_Types();

		/*
		 * Require Post Type related Class
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-boorecipe-premium-custom_posts.php';
		$premium_post_types = new Boorecipe_Premium_Post_Types();


		$new_taxonomies = $premium_post_types->get_taxonomies_create_args();

		if ( is_array( $new_taxonomies ) && ! empty( $new_taxonomies ) ) {
			foreach ( $new_taxonomies as $taxonomy ) {
				$plugin_post_types->register_single_post_type_taxonomy( $taxonomy );
			}
		}


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
	} // create_premium_taxonomies


}

