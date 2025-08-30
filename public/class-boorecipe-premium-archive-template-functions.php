<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Premium_Archive_Template_Functions' ) ) {
	return;
}
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the methods for creating the templates.
 *
 * @package    Now_Hiring
 * @subpackage Now_Hiring/public
 *
 */

// Require the class file from parent plugin as the premium class is extending that class
require_once BOORECIPE_BASE_DIR . 'public/class-boorecipe-archive-template-functions.php';

class Boorecipe_Premium_Archive_Template_Functions extends Boorecipe_Archive_Template_Functions {

	/**
	 * Include      public/templates/archive/archive-recipe-key-points
	 *
	 * @hooked      boorecipe_archive_recipe_key_points        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function archive_recipe_key_points_total_time( $item, $meta ) {

		$key_point           = 'total_time';
		$time_format_measure = isset( $meta['recipe_time_format'] ) ? boorecipe_get_default_options( $meta['recipe_time_format'] ) : "";

		$key_point_label = $this->get_options_value( $key_point . '_label' );
		$key_point_value = isset( $meta[ $key_point ] ) ? $meta[ $key_point ] . " " . $time_format_measure : false;

		if ( isset( $meta[ $key_point ] ) && $meta[ $key_point ] ) {
			include boorecipe_get_template( 'archive-recipe-key-points', 'archive' );
		}

	} //archive_recipe_key_points_total_time


	/**
	 * Include      public/templates/archive/archive-author-name
	 *
	 * @hooked      boorecipe_archive_recipe_content        8
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function archive_recipe_author_name( $item, $meta ) {

		if ( $this->get_options_value( 'recipe_archive_layout' ) === 'overlay' ) {
			$recipe_author_name = $this->get_recipe_author( $item, $meta, false );
			include boorecipe_get_template( 'archive-author-name', 'archive' );
		}

	} // archive_recipe_author_name

	/**
	 * @hooked      boorecipe_filter_archive_recipe_card_classes
	 *
	 * @param array $classes_array
	 *
	 * @return array $classes_array
	 */
	public function filter_archive_recipe_card_classes( $classes_array ) {

		if ( ! boorecipe_is_archive_query() ) {
			return $classes_array;
		}

		$recipe_archive_layout = $this->get_options_value( 'recipe_archive_layout' );

		switch ( $recipe_archive_layout ) {
			case( 'modern' ):
				$classes_array[] = 'modern-archive';
				break;

			case( 'overlay' ):
				$classes_array[] = 'overlay-archive';
				break;

			default:
		}

		return $classes_array;

	} // filter_archive_recipe_card_classes


	/**
	 * @hooked      boorecipe_filter_archive_recipe_wrap_classes
	 *
	 * @param array $classes_array
	 *
	 * @return array $classes_array
	 */
	public function filter_archive_recipe_wrap_classes( $classes_array ) {

		if ( ! boorecipe_is_archive_query() ) {
			return $classes_array;
		}


		$recipe_archive_layout = $this->get_options_value( 'recipe_archive_layout' );

		switch ( $recipe_archive_layout ) {
			case( 'modern' ):
				$classes_array['layout'] = 'recipes-layout-modern';
				break;

			case( 'overlay' ):
				$classes_array['layout'] = 'recipes-layout-overlay';
				break;

			default:
		}

		if ( $this->get_options_value( 'show_in_masonry' ) === 'yes' ) {
			$classes_array['masonry'] = 'masonry-grid';
		}

		return $classes_array;
	} // filter_archive_recipe_wrap_classes


} // class