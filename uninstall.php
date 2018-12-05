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


		$all_recipes = get_posts( 'numberposts=-1&post_type=boo_recipe&post_status=any' );

		// delete all recipes
		foreach ( $all_recipes as $recipe ) {
			wp_delete_post( $recipe->ID, true );
		}


		// delete all postmeta
		$meta_keys = Boorecipe_Globals::get_meta_fields();
		foreach ( $meta_keys as $meta_key ) {
			delete_post_meta_by_key( $meta_key );
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
			$terms = get_terms( $taxonomy, array( 'fields' => 'ids', 'hide_empty' => false ) );

			if ( is_array( $terms ) && ! empty( $terms ) ) {
				foreach ( $terms as $term_id ) {
					wp_delete_term( $term_id, $taxonomy );
				}
			}
		}


	}
}




// Bue Bye, Good Luck!