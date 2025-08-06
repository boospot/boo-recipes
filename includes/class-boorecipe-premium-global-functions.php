<?php

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Premium_Globals' ) ) {
	return;
}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the methods for creating the templates.
 *
 * @package    Boorecipe
 * @subpackage Boorecipe/public
 *
 */

// Require the class file from parent plugin as the premium class is extending that class
require_once BOORECIPE_PREMIUM_PARENT_BASE_DIR . 'includes/class-boorecipe-global-functions.php';

class Boorecipe_Premium_Globals extends Boorecipe_Globals {


	/**
	 * @param array $default_labels
	 *
	 * @return array $default_labels
	 */
	public function filter_default_options_array( $default_options ) {

		$Premium_default_options = array(
			'related_recipes_show'          => 'yes',
			'related_recipes_basis'         => 'recipe_category',
			'related_recipes_limit'         => 3,
			'related_recipes_per_row'       => 3,
			'related_recipes_layout'        => 'modern',
			'uninstall_delete_comment_meta' => 'no',
			'enable_ratings'                => 'yes'

		);

		$default_options = array_merge( $Premium_default_options, $default_options );

		return $default_options;
	}


	/**
	 * @param array $default_labels
	 *
	 * @return array $default_labels
	 */
	public function filter_default_labels_array( $default_labels ) {

		$Premium_default_labels = array(
			'recipe_cuisine_label'          => __( 'Cuisine', 'boorecipe-premium' ),
			'cooking_method_label'          => __( 'Cooking Method', 'boorecipe-premium' ),
			'user_rating_label'             => __( 'Recipe Ratings', 'boorecipe-premium' ),
			'rating_start_label'            => __( 'Rated', 'boorecipe-premium' ),
			'rating_based_on_label'         => __( 'based on', 'boorecipe-premium' ),
			'rating_customer_reviews_label' => __( 'customer reviews', 'boorecipe-premium' ),
			'recipe_tool_label'             => __( 'Recipe Tools', 'boorecipe-premium' ),
			'author_link_label'             => __( 'All Recipes by the %s', 'boorecipe-premium' ),
			'archive_layout_modern_label'   => _x( 'Modern', 'Post Archive Layout', 'boorecipe-premium' ),
			'archive_layout_overlay_label'  => _x( 'Overlay', 'Post Archive Layout', 'boorecipe-premium' ),
			'related_recipes_label'         => __( 'Related Recipes', 'boorecipe-premium' ),
			'recipe_ratings_label'          => __( 'Recipe Ratings', 'boorecipe-premium' ),
			'cooking_method_slug'           => 'cooking-method',
			'recipe_cuisine_slug'           => 'recipe-cuisine',
			'recipe_tool_slug'              => 'recipe-tool',
			'show_recipe_tool_img'          => 'no',
			'show_cooking_method_img'       => 'no'

		);

		$default_labels = array_merge( $Premium_default_labels, $default_labels );

		return $default_labels;
	}


} // class