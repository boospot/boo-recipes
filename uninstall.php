<?php
// If uninstall not called from WordPress, then exit.
if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$plugin_option_id         = 'boorecipe-options';
$plugin_widgets_option_id = 'boorecipe-registered-shortcodes';
$plugin_meta_key          = 'boorecipe-recipe-meta';

$current_language_code = mb_substr( get_locale(), 0, 2 );;

$plugin_options = get_option( $plugin_option_id );


if ( ! empty( $plugin_options ) ) {


	/*
	 * Delete options if options say so
	 */
	$uninstall_delete_options = isset( $plugin_options[ $current_language_code ]['uninstall_delete_options'] ) ? $plugin_options[ $current_language_code ]['uninstall_delete_options'] : 'yes';

	if ( $uninstall_delete_options === 'yes' ) {
		delete_option( $plugin_option_id );
		delete_option( $plugin_widgets_option_id );
	}

}


/*
 * Delete recipe meta data if options say so
 */

$uninstall_delete_meta = isset( $plugin_options[ $current_language_code ]['uninstall_delete_meta'] ) ? $plugin_options[ $current_language_code ]['uninstall_delete_meta'] : 'no';

if ( $uninstall_delete_meta === 'yes' ) {


	$all_recipes = get_posts( 'numberposts=-1&post_type=boo_recipe&post_status=any' );

	foreach ( $all_recipes as $recipe ) {

		$meta_values = get_post_meta( $recipe->ID );
		foreach ( $meta_values as $key => $val ) {
			delete_post_meta( $recipe->ID, $key );
		}

		wp_delete_post( $recipe->ID, true );


//		wp_delete_object_term_relationships( $recipe->ID, $recipe_taxonomies );

	}



// delete all terms of taxonomies
	$recipe_taxonomies = array(
		'recipe_category',
		'recipe_cuisine',
		'skill_level',
		'recipe_tags',
		'cooking_method'
	);


	foreach ( $recipe_taxonomies as $taxonomy ) {
		global $wpdb;

		$query = 'SELECT t.name, t.term_id
            FROM ' . $wpdb->terms . ' AS t
            INNER JOIN ' . $wpdb->term_taxonomy . ' AS tt
            ON t.term_id = tt.term_id
            WHERE tt.taxonomy = "' . $taxonomy . '"';

		$terms = $wpdb->get_results($query);

		foreach ($terms as $term) {
			wp_delete_term( $term->term_id, $taxonomy );
		}

		wp_reset_query();

	}



}




// Bye Bye, Good Luck!