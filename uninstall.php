<?php
// If uninstall not called from WordPress, then exit.
if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$plugin_option_id         = 'boorecipe-options';
$plugin_widgets_option_id = 'boorecipe-registered-shortcodes';
$plugin_meta_key          = 'boorecipe-recipe-meta';


$plugin_options = get_option( $plugin_option_id );


if ( ! empty( $plugin_options ) ) {


	/*
	 * Delete options if options say so
	 */
	$uninstall_delete_options = isset( $plugin_options['uninstall_delete_options'] ) ? $plugin_options['uninstall_delete_options'] : 'yes';

	if ( $uninstall_delete_options === 'yes' ) {
		delete_option( $plugin_option_id );
		delete_option( $plugin_widgets_option_id );
	}


	/*
	 * Delete recipe meta data if options say so
	 */

	$uninstall_delete_meta = isset( $plugin_options['uninstall_delete_meta'] ) ? $plugin_options['uninstall_delete_meta'] : 'no';

	if ( $uninstall_delete_meta === 'yes' ) {

		$meta_type  = 'post';           // since we are deleting data for CPT
		$object_id  = 0;                // no need to put id of object since we are deleting all
		$meta_key   = $plugin_meta_key;    // Your target meta_key added using update_post_meta()
		$meta_value = '';               // No need to check for value since we are deleting all
		$delete_all = true;             // This is important to have TRUE to delete all post meta

		// This will delete all post meta data having the specified key
		$deleted = delete_metadata( $meta_type, $object_id, $meta_key, $meta_value, $delete_all );

		if ( $deleted ) {
			wp_cache_set( 'last_changed', microtime(), 'posts' );
		}

	}
}




// Bue Bye, Good Luck!