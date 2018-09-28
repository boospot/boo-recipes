<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// if class already defined, bail out
if ( class_exists( 'Boorecipe_Deactivator' ) ) {
	return;
}
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Boorecipe
 * @subpackage Boorecipe/includes
 * @author     Rao Abid <raoabid491@gmail.com>
 */
class Boorecipe_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		// unregister the post type, so the rules are no longer in memory
		unregister_post_type( 'boo_recipe' );
		// clear the permalink to remove our post type's rules from the database
		flush_rewrite_rules();

	}

}
