<?php
/** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection PhpUnusedParameterInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Single_Template_Functions' ) ) {
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
class Boorecipe_Single_Template_Functions extends Boorecipe_Template_Functions {


	/**
	 * Include      public/templates/single/sub-section-head-title
	 *
	 * @hooked      boorecipe_single_media        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function recipe_featured_image( $item, $meta ) {

		// Assuming there is no slider or video
		$is_video_or_slider = false;

		$is_video_or_slider = apply_filters( 'boorecipe_before_showing_featured_image', $is_video_or_slider, $meta );

		if ( $is_video_or_slider ) {
			// Exit if we have slider or Video
			return;
		}

		$image_size = $this->get_options_value( 'recipe_image_size_' . $this->get_options_value( 'recipe_style' ) );

		$featured_image = get_the_post_thumbnail_url( $item->ID, $image_size );

		//Assign default if empty
		if ( empty( $featured_image ) ) {
			$featured_image = $this->get_recipe_featured_image_default();
		}

		include boorecipe_get_template( 'single-recipe-featured-image', 'single' );

	}


	/**
	 * Include      public/templates/single/sub-section-head-title
	 *
	 * @hooked      boorecipe_single_head        10
	 *
	 * @param       object $item A post object
	 */
	public function the_title( $item ) {

		include boorecipe_get_template( 'sub-section-head-title', 'single' );

	} // the_title


	/**
	 * Include      public/templates/single/single-recipe-author-name
	 *
	 * @hooked       boorecipe_single_head_publish_info        10
	 *
	 * @param        object $item A post object
	 * @param        array $meta The post metadata
	 */
	public function the_author( $item, $meta ) {

		if (
			( $this->get_options_value( 'show_author' ) === 'yes' )
			&&
			( $this->get_options_value( 'show_author_box' ) === 'no' ||
			  ! $this->get_options_value( 'show_author_box'
			  )
			)
		):

			//		$recipe_author will be used in the template file
			$recipe_author_with_link = $this->get_recipe_author( $item, $meta );
			include boorecipe_get_template( 'single-recipe-author-name', 'single' );

		endif;


	}

	/**
	 * Include      public/templates/single/sub-section-publish-info
	 *
	 * @hooked action   boorecipe_single_head   10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function sub_section_publish_info( $item, $meta ) {

		include boorecipe_get_template( 'sub-section-publish-info', 'single' );

	} //sub_section_publish_info()


	/**
	 * Include      public/templates/single/sub-section-short-description
	 *
	 * @hooked action     boorecipe_single_head        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function sub_section_short_description( $item, $meta ) {

		include boorecipe_get_template( 'sub-section-short-description', 'single' );

	} // sub_section_short_description()


	/**
	 * Include      public/templates/single/sub-section-meta-taxonomy
	 *
	 * @hooked      boorecipe_single_meta        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function sub_section_meta_taxonomy_style_1( $item, $meta ) {

		if ( $this->get_options_value( 'recipe_style' ) !== 'style1' ) {
			return;
		}

		include boorecipe_get_template( 'sub-section-meta-taxonomy', 'single' );
	} // sub_section_meta_taxonomy_style_1()


	/**
	 * Include      public/templates/single/sub-section-meta-key-point-style-1
	 *
	 * @hooked      boorecipe_single_meta        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function sub_section_meta_key_point_style_1( $item, $meta ) {

		if ( $this->get_options_value( 'recipe_style' ) !== 'style1' ) {
			return;
		}

		include boorecipe_get_template( 'sub-section-meta-key-point-style-1', 'single' );
	} //sub_section_meta_key_point_style_1()


	/**
	 * Include      public/templates/single/section-share-buttons
	 *
	 * @hooked      boorecipe_single_head_after        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function section_sharing_buttons_style_1( $item, $meta ) {

		if ( $this->get_options_value( 'recipe_style' ) !== 'style1' ) {
			return;
		}

		if ( $this->get_options_value( 'show_share_buttons' ) === 'yes' ):
			$image_size         = boorecipe_get_default_options( 'recipe_image_size' );
			$featured_image_url = get_the_post_thumbnail_url( $item->ID, $image_size );
			//Assign default if empty
			if ( empty( $featured_image_url ) ) {
				$featured_image_url = $this->get_recipe_featured_image_default();
			}


			$title   = urlencode( $item->post_title );
			$excerpt = ( ! empty( trim( $item->post_excerpt ) ) ) ? $item->post_excerpt : $meta['short_description'];

			// Adjust the max length of excerpt for different social sites sharing
			$excerpt = substr( $excerpt, 0, 145 ) . "...";

			include boorecipe_get_template( 'section-share-buttons', 'single' );

		endif;

	} // section_sharing_buttons_style_1()


	/**
	 * Include      public/templates/single/sub-section-icon
	 *
	 * @hooked      boorecipe_single_meta_taxonomy        8
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function the_taxonomy_icon( $item, $meta ) {

		if ( $this->get_options_value( 'show_icons' ) !== 'yes' ) {
			return;
		}

		$svg = 'tags';
		include boorecipe_get_template( 'sub-section-icon', 'single' );
	} //the_taxonomy_icon()


	/**
	 * Include      public/templates/single/sub-section-icon
	 *
	 * @hooked      boorecipe_single_meta_taxonomy        8
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function the_time_icon( $item, $meta ) {
		if ( $this->get_options_value( 'show_icons' ) !== 'yes' ) {
			return;
		}

		$svg = 'clock';
		include boorecipe_get_template( 'sub-section-icon', 'single' );
	}

	/**
	 * Include      public/templates/single/sub-section-icon
	 *
	 * @hooked      boorecipe_single_meta_taxonomy        8
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function the_key_point_icon( $item, $meta ) {
		if ( $this->get_options_value( 'show_icons' ) !== 'yes' ) {
			return;
		}

		$svg = 'utensils';
//		$svg_class = 'icon-size-32';
		include boorecipe_get_template( 'sub-section-icon', 'single' );
	}


	/**
	 * Include      public/templates/single/sub-section-meta-key-point-entry
	 *
	 * @hooked      boorecipe_single_meta_key_point_style_1        9
	 *
	 * @param        object $item A post object
	 * @param        array $meta The post metadata
	 */
	public function yields( $item, $meta ) {

		$key_point = 'yields';
		$itemprop  = 'recipeYield';

		$key_point_label = $this->get_options_value( $key_point . '_label' );
		$key_point_value = isset( $meta[ $key_point ] ) ? $meta[ $key_point ] : false;

		if ( $meta[ $key_point ] ) {
			include boorecipe_get_template( 'sub-section-meta-key-point-entry', 'single' );
		}

	} // difficulty_level()


	/**
	 * Include      public/templates/single/sub-section-meta-taxonomy-entry
	 *
	 * @hooked      boorecipe_single_meta_key_point_style_1        9
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function the_taxonomy_skill_level( $item, $meta ) {

		$taxonomy       = 'skill_level';
		$taxonomy_label = $this->get_options_value( $taxonomy . '_label' );
		$taxonomy_terms = $this->get_taxonomy_terms( $item->ID, $taxonomy );

		$itemprop = 'keywords';

		if ( ! empty( $taxonomy_terms ) ) {
			include boorecipe_get_template( 'sub-section-meta-taxonomy-entry', 'single' );
		}


	} // the_taxonomy_skill_level()


	/**
	 * Include      public/templates/single/section-recipe-ingredients
	 *
	 * @hooked      boorecipe_single_body        9
	 *
	 * @param        object $item A post object
	 * @param        array $meta The post metadata
	 */
	public function ingredients( $item, $meta ) {

		include boorecipe_get_template( 'section-recipe-ingredients', 'single' );

	} // ingredients()

	/**
	 * Include      public/templates/single/section-recipe-ingredients
	 *
	 * @hooked      boorecipe_single_body        10
	 *
	 * @param        object $item A post object
	 * @param        array $meta The post metadata
	 */
	public function instructions( $item, $meta ) {

		include boorecipe_get_template( 'section-recipe-instructions', 'single' );

	} // instructions()

	/**
	 * Include      public/templates/single/section-recipe-additional-notes
	 *
	 * @hooked      boorecipe_single_body        10
	 *
	 * @param        object $item A post object
	 * @param        array $meta The post metadata
	 */
	public function additional_notes( $item, $meta ) {

		$meta_key = 'additional_notes';
		if ( ! empty( trim( $meta[ $meta_key ] ) ) ) {
			include boorecipe_get_template( 'section-recipe-additional-notes', 'single' );
		}

	} // additional_notes()


	/**
	 * Include      public/templates/single/section-recipe-ingredients
	 *
	 * @hooked       boorecipe_single_body        11
	 *
	 * @param        object $item A post object
	 * @param        array $meta The post metadata
	 */
	public function nutrition( $item, $meta ) {

		// If the Option is set to show nutrition
		if ( $this->get_options_value( 'show_nutrition' ) === 'yes' && $meta['show_nutrition'] === 'yes' ) {

			$meta_key = 'nutrition';
			include boorecipe_get_template( 'section-recipe-nutrition', 'single' );

		}

	} // nutrition()


	/**
	 * Include      public/templates/single/sub-section-meta-time-entry
	 *
	 * @hooked      boorecipe_single_meta_time_style_1        9
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function recipe_prep_time( $item, $meta ) {

		$time     = 'prep_time';
		$itemprop = 'prepTime';

		$time_value = ( $meta[ $time ] > 0 ) ? $meta[ $time ] : 0;;
		$time_label = $this->get_options_value( $time . '_label' );

		include boorecipe_get_template( 'sub-section-meta-time-entry', 'single' );
	}


	/**
	 * Include      public/templates/single/sub-section-meta-time-entry
	 *
	 * @hooked      boorecipe_single_meta_time_style_1        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function recipe_cook_time( $item, $meta ) {

		$time     = 'cook_time';
		$itemprop = 'cookTime';

		$time_value = ( $meta[ $time ] > 0 ) ? $meta[ $time ] : 0;;
		$time_label = $this->get_options_value( $time . '_label' );

		include boorecipe_get_template( 'sub-section-meta-time-entry', 'single' );
	}


	/**
	 * Include      public/templates/single/sub-section-meta-time-entry
	 *
	 * @hooked      boorecipe_single_meta_time_style_1        11
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function recipe_total_time( $item, $meta ) {

		$time     = 'total_time';
		$itemprop = 'totalTime';

		$time_value = ( $meta[ $time ] > 0 ) ? $meta[ $time ] : 0;;
		$time_label = $this->get_options_value( $time . '_label' );

		include boorecipe_get_template( 'sub-section-meta-time-entry', 'single' );
	}


	/**
	 * Includes      public/templates/single/sub-section-meta-taxonomy-entry
	 *
	 * @hooked       boorecipe_single_meta_taxonomy        9
	 *
	 * @param        object $item A post object
	 * @param        array $meta The post metadata
	 */
	public function the_taxonomy_category( $item, $meta ) {

		$taxonomy       = 'recipe_category';
		$taxonomy_label = $this->get_taxonomy_label( $taxonomy );
		$taxonomy_terms = $this->get_taxonomy_terms( $item->ID, $taxonomy );

		$itemprop = 'recipeCategory';

		if ( ! empty( $taxonomy_terms ) ) {
			include boorecipe_get_template( 'sub-section-meta-taxonomy-entry', 'single' );
		}

	}


	/**
	 * Includes      public/templates/single/sub-section-meta-taxonomy-entry
	 *
	 * @hooked       boorecipe_single_meta_taxonomy        11
	 *
	 * @param        object $item A post object
	 * @param        array $meta The post metadata
	 */
	public function the_taxonomy_tags( $item, $meta ) {
		$taxonomy       = 'recipe_tags';
		$taxonomy_label = $this->get_taxonomy_label( $taxonomy );
		$taxonomy_terms = $this->get_taxonomy_terms( $item->ID, $taxonomy );

		if ( ! empty( $taxonomy_terms ) ) {
			include boorecipe_get_template( 'sub-section-meta-taxonomy-entry', 'single' );
		}

	} // the_taxonomy_tags()


	/**
	 * Includes   public/templates/single/sub-section-head-publish-info
	 *
	 * @hooked       boorecipe_single_head_publish_info        10
	 *
	 * @param        object $item A post object
	 * @param        array $meta The post metadata
	 */
	public function the_date( $item, $meta ) {

		if ( $this->get_options_value( 'show_published_date' ) === 'yes' ):
			include boorecipe_get_template( 'sub-section-head-publish-info', 'single' );
		endif;

	}   // the_date()


	/**
	 * Include      public/templates/single/sub-section-meta-time-style-1
	 *
	 * @hooked      boorecipe_single_meta        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function sub_section_meta_time_style_1( $item, $meta ) {

		if ( $this->get_options_value( 'recipe_style' ) !== 'style1' ) {
			return;
		}

		include boorecipe_get_template( 'sub-section-meta-time-style-1', 'single' );

	} //sub_section_single_taxonomy


	/**
	 * Filter the Single recipe wrapper classes
	 *
	 * @hooked boorecipe_single_recipe_wrapper_classes
	 *
	 * @param array $wrapper_classes_array
	 *
	 * @return array
	 */
	public function filter_recipe_wrapper_classes( $wrapper_classes_array ) {

		$layout = $this->get_options_value( 'recipe_layout' );

		$is_sidebar = ( $layout == 'right' || $layout == 'left' ) ? true : false;

		if ( $layout ) {
			$wrapper_classes_array[] = 'posttype-layout-' . $layout;
		}

		if ( $is_sidebar ) {
			$wrapper_classes_array[] = 'has-sidebar';
		}

		return $wrapper_classes_array;
	}

	/**
	 * Filter the Single recipe post classes
	 *
	 * @hooked boorecipe_single_recipe_post_classes 10
	 *
	 * @param $classes_array
	 *
	 * @return array
	 */
	public function filter_recipe_post_classes( $classes_array ) {

		if ( ! is_array( $classes_array ) ) {
			$classes_array = array( $classes_array );
		}
		// Recipe Post Arrays
		$classes_array[] = 'posttype-container';
		$classes_array[] = 'boorecipe-recipe';
		$classes_array[] = ( $this->get_options_value( 'ingredient_side' ) === 'yes' ) ? 'ingredient-side' : '';
		$classes_array[] = ( $this->get_options_value( 'nutrition_side' ) === 'yes' ) ? 'nutrition-side' : '';
		$classes_array[] = 'single-recipe-' . $this->get_options_value( 'recipe_style' );

		return $classes_array;
	}


	/**
	 * filter classes
	 */
	public function add_single_recipe_style_class( $classes ) {

		$classes[] = 'recipe-layout-' . $this->get_options_value( 'recipe_style' );

		return $classes;
	}



} // class