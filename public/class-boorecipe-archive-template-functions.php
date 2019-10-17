<?php
/** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection PhpUnusedParameterInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Archive_Template_Functions' ) ) {
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
class Boorecipe_Archive_Template_Functions extends Boorecipe_Template_Functions {


	/**
	 * Include      public/templates/archive/archive-wrap-start
	 *
	 * @hooked      boorecipe_archive_wrap_start        10
	 */
	public function archive_wrap_start() {

		include boorecipe_get_template( 'archive-wrap-start', 'archive' );

	} //archive_wrap_start

	/**
	 * Include      public/templates/archive/archive-wrap-end
	 *
	 * @hooked      boorecipe_archive_wrap_end        10
	 */
	public function archive_wrap_end() {

		include boorecipe_get_template( 'archive-wrap-end', 'archive' );

	} //archive_wrap_end

	/**
	 * Include      public/templates/archive/archive-wrap-end
	 *
	 * @hooked      boorecipe_archive_no_result        10
	 */
	public function archive_no_result() {

		echo wpautop( __( 'Sorry, no recipes were found for this search criteria', 'boorecipe' ) );

	} // archive_no_result


	/**
	 * Include      public/templates/archive/pagination-links
	 *
	 * @hooked      boorecipe_archive_wrap_end_inside        10
	 */
	public function archive_pagination_links() {

		include boorecipe_get_template( 'pagination-links', 'archive' );
	}


	/**
	 * Include      public/templates/archive/layout-switcher
	 *
	 * @hooked      boorecipe_archive_wrap_start_inside        10
	 */
	public function insert_layout_switcher() {

		if (
			$this->get_options_value( 'show_layout_switcher' ) === 'yes'
			&& $this->get_options_value( 'show_in_masonry' ) !== 'yes'
			&& (
				$this->get_options_value( 'recipe_archive_layout' ) === 'grid'
				||
				$this->get_options_value( 'recipe_archive_layout' ) === 'list'
			)
		) {
			include boorecipe_get_template( 'layout-switcher', 'archive' );
		}

	} // insert_layout_switcher


	/**
	 * Include      public/templates/archive/search-form
	 *
	 * @hooked      boorecipe_archive_wrap_start_inside        11
	 */
	public function insert_search_form() {

		if (
			$this->get_options_value( 'show_search_form' ) === 'yes'
//			&&
//			! boorecipe_is_search_form_submitted()
		) {

			$submit_button_label = $this->get_options_value( 'recipe_submit_button_label' );

			include boorecipe_get_template( 'search-form', 'widgets' );
		}
	} // insert_search_form


	/**
	 * Include      public/templates/archive/search-form
	 *
	 * @hooked      boorecipe_archive_wrap_start_inside        11
	 */
	public function insert_search_form_at_end() {

		if ( boorecipe_is_search_form_submitted() ) {
			include boorecipe_get_template( 'search-form', 'widgets' );
		}
	} // insert_search_form_at_end


	/**
	 * Include      public/templates/archive/archive-featured-image
	 *
	 * @hooked      boorecipe_archive_recipe_media        10
	 *
	 * @param object $item
	 */
	public function archive_recipe_media_featured_image( $item ) {
		include boorecipe_get_template( 'archive-featured-image', 'archive' );
	} //archive_recipe_media_featured_image()

	/**
	 * Include      public/templates/archive/archive-recipe-title
	 *
	 * @hooked      boorecipe_archive_recipe_content        8
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function archive_recipe_title( $item, $meta ) {
		include boorecipe_get_template( 'archive-recipe-title', 'archive' );
	}//archive_recipe_title()


	/**
	 * Include      public/templates/archive/archive-recipe-excerpt
	 *
	 * @hooked      boorecipe_archive_recipe_content        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function archive_recipe_excerpt( $item, $meta ) {


		if ( $this->get_options_value( 'show_archive_excerpt' ) === 'yes' ) {
			include boorecipe_get_template( 'archive-recipe-excerpt', 'archive' );

		}

	} // archive_recipe_excerpt()

	/**
	 * Include      public/templates/archive/archive-recipe-key-points
	 *
	 * @hooked      boorecipe_archive_recipe_key_points        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function archive_recipe_key_points_yields( $item, $meta ) {

		$key_point = 'yields';

		$key_point_label = $this->get_options_value( $key_point . '_label' );
		$key_point_value = isset( $meta[ $key_point ] ) ? $meta[ $key_point ] : false;

		if ( $key_point_value ) {
			include boorecipe_get_template( 'archive-recipe-key-points', 'archive' );
		}

	} // archive_recipe_key_points_yields()

	/**
	 * Include      public/templates/archive/archive-recipe-key-points
	 *
	 * @hooked      boorecipe_archive_recipe_key_points        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function archive_recipe_key_points_skill_level( $item, $meta ) {

		$key_point       = 'skill_level';
		$key_point_label = $this->get_taxonomy_label( $key_point );
		$key_point_value = $this->get_taxonomy_term_single_text( $item->ID, $key_point );

		if ( $key_point_value ) {
			include boorecipe_get_template( 'archive-recipe-key-points', 'archive' );
		}

	} //archive_recipe_key_points_skill_level()


	/**
	 * Sets the layout for archive
	 *
	 * @hooked filter boorecipe_set_archive_layout
	 *
	 * @return string layout name
	 */
	public function filter_set_layout() {
		$archive_layout = $this->get_options_value( 'recipe_archive_layout' );

		return $archive_layout;
	}


	/**
	 * @hooked  boorecipe_filter_archive_recipe_wrap_classes    10
	 *
	 * @param array $classes_array
	 *
	 * @return array $classes_array
	 */
	public function filter_archive_recipe_wrap_classes( $classes_array ) {

		if ( ! boorecipe_is_archive_query() ) {
			return $classes_array;
		}


//		if ( $this->get_options_value( 'show_in_masonry' ) === 'yes' ) {
//			$classes_array['masonry'] = 'masonry-grid';
//		}

		$recipe_archive_layout = $this->get_options_value( 'recipe_archive_layout' );

		switch ( $recipe_archive_layout ) {
			case( 'grid' ):
				$classes_array['layout'] = 'recipes-layout-grid';
				break;

			case( 'list' ):
				$classes_array['layout'] = 'recipes-layout-list';
				break;

			default:
		}

		$recipes_per_row = $this->get_options_value( 'recipes_per_row' );

//		if ( is_post_type_archive( 'boo_recipe' ) ) {
		$classes_array['per_row'] = 'per-row-' . sanitize_html_class( $recipes_per_row );

//		}


		return $classes_array;
	}


	/**
	 *
	 * @hooked  boorecipe_filter_archive_recipe_card_classes    10
	 *
	 *
	 * @param array $classes_array
	 *
	 * @return array
	 */
	public function filter_archive_recipe_card_classes( $classes_array ) {

		if ( ! boorecipe_is_archive_query() ) {
			return $classes_array;
		}

		$recipe_archive_layout = $this->get_options_value( 'recipe_archive_layout' );

		switch ( $recipe_archive_layout ) {
			case( 'grid' ):
				$classes_array[] = 'grid-archive';
				break;

			case( 'list' ):
				$classes_array[] = 'list-archive';
				break;

			default:
		}

		if ( $this->get_options_value( 'show_in_masonry' ) === 'yes' ) {
			$classes_array[] = 'masonry-grid-item';
		}


		return $classes_array;
	}


	/**
	 *
	 * @hooked      boorecipe_filter_archive_image_size        10
	 *
	 * @param string $image_size_identifier
	 *
	 * @return string $image_size_identifier
	 */
	public function filter_archive_image_size( $image_size_identifier ) {

		if (
			$this->get_options_value( 'show_layout_switcher' ) !== 'yes' &&
			$this->get_options_value( 'recipe_archive_layout' ) === 'list'
		) {
			$image_size_identifier = $this->get_options_value( 'list_view_image_size' );

		}


		if ( $this->get_options_value( 'recipes_per_row' ) === 1 || $this->get_options_value( 'recipe_archive_layout' ) === 'overlay' ) {
			$image_size_identifier = 'recipe_image';
		}


		return $image_size_identifier;
	}

	/**
	 * Set the heading tag for archive title
	 *
	 * @param string $title_text
	 *
	 * @return string
	 */
	public function filter_archive_title_args( $title_text ) {

		$h = sanitize_key( $this->get_options_value( 'heading_for_archive_title' ) );

		$title_text = "<$h>$title_text</$h>";

		return $title_text;


	}


} // class