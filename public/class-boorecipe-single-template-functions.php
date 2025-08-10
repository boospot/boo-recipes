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

		// Dont show featured image if settings say so:
		if ( $this->get_options_value( 'show_featured_image' ) != 'yes' ) {
			return null;
		}

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
	 * @param object $item A post object
	 */
	public function the_title( $item ) {

		// Dont show if settings say so:
		if ( $this->get_options_value( 'show_recipe_title' ) == 'no' ) {
			return null;
		}

		include boorecipe_get_template( 'sub-section-head-title', 'single' );

	} // the_title


	/**
	 * Include      public/templates/single/single-recipe-author-name
	 *
	 * @hooked       boorecipe_single_head_publish_info        10
	 *
	 * @param object $item A post object
	 * @param array $meta The post metadata
	 */
	public function the_author( $item, $meta ) {

		if (
			( $this->get_options_value( 'show_author' ) === 'yes' )
			&&
			( $this->get_options_value( 'show_author_box' ) === 'no' ||
			  ! $this->get_options_value( 'show_author_box' )
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

		// Dont show if settings say so:
		if ( $this->get_options_value( 'show_recipe_publish_info' ) == 'no' ) {
			return null;
		}

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
	 * Unified icon display function for all icon types
	 *
	 * @param object $item
	 * @param array $meta
	 * @param string $icon_type The type of icon to display ('taxonomy', 'time', 'key_point')
	 */
	public function display_icon( $item, $meta, $icon_type = 'taxonomy' ) {
		if ( $this->get_options_value( 'show_icons' ) !== 'yes' ) {
			return;
		}

		// Define icon mapping
		$icon_map = array(
			'taxonomy'  => 'tags',
			'time'      => 'clock', 
			'key_point' => 'utensils'
		);

		// Get the appropriate SVG icon
		$svg = isset( $icon_map[ $icon_type ] ) ? $icon_map[ $icon_type ] : 'tags';
		
		// Include the icon template
		include boorecipe_get_template( 'sub-section-icon', 'single' );
	}

	/**
	 * Unified taxonomy icon - wrapper for display_icon
	 *
	 * @hooked      boorecipe_single_meta_taxonomy        8
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function unified_taxonomy_icon( $item, $meta ) {
		$this->display_icon( $item, $meta, 'taxonomy' );
	}

	/**
	 * Unified time icon - wrapper for display_icon
	 *
	 * @hooked      boorecipe_single_meta_time        8
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function unified_time_icon( $item, $meta ) {
		$this->display_icon( $item, $meta, 'time' );
	}

	/**
	 * Unified key point icon - wrapper for display_icon
	 *
	 * @hooked      boorecipe_single_meta_key_point_style_1        8
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function unified_key_point_icon( $item, $meta ) {
		$this->display_icon( $item, $meta, 'key_point' );
	}


	/**
	 * Include      public/templates/single/sub-section-meta-key-point-entry
	 *
	 * @hooked      boorecipe_single_meta_key_point_style_1        9
	 *
	 * @param object $item A post object
	 * @param array $meta The post metadata
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
	 * @param object $item A post object
	 * @param array $meta The post metadata
	 */
	public function ingredients( $item, $meta ) {


		include boorecipe_get_template( 'section-recipe-ingredients', 'single' );

	} // ingredients()

	/**
	 * Include      public/templates/single/section-recipe-ingredients
	 *
	 * @hooked      boorecipe_single_body        10
	 *
	 * @param object $item A post object
	 * @param array $meta The post metadata
	 */
	public function instructions( $item, $meta ) {

		include boorecipe_get_template( 'section-recipe-instructions', 'single' );

	} // instructions()

	/**
	 * Include      public/templates/single/section-recipe-additional-notes
	 *
	 * @hooked      boorecipe_single_body        10
	 *
	 * @param object $item A post object
	 * @param array $meta The post metadata
	 */
	public function additional_notes( $item, $meta ) {

		$meta_key = 'additional_notes';
		if ( ! empty( trim( $meta[ $meta_key ] ) ) ) {
			include boorecipe_get_template( 'section-recipe-additional-notes', 'single' );
		}

	} // additional_notes()


	/**
	 * Include      public/templates/single/section-recipe-nutrition
	 *
	 * @hooked       boorecipe_single_body        11
	 * @hooked       boorecipe_recipe_single_aside 10
	 *
	 * @param object $item A post object
	 * @param array $meta The post metadata
	 */
	public function nutrition( $item, $meta ) {

		// Check global nutrition setting
		$global_nutrition = $this->get_options_value( 'show_nutrition' );
		
		// Check individual recipe nutrition setting
		$recipe_nutrition = isset( $meta['show_nutrition'] ) ? $meta['show_nutrition'] : '';
		
		// Check if nutrition should be on the side
		$nutrition_side = $this->get_options_value( 'nutrition_side' );
		
		// More flexible condition check - handle different data types
		$should_show_nutrition = false;
		
		if ( $global_nutrition === 'yes' ) {
			// Check if recipe nutrition is enabled (handle various formats)
			if ( $recipe_nutrition == 1 || $recipe_nutrition === 'yes' || $recipe_nutrition === '1' || $recipe_nutrition === true ) {
				$should_show_nutrition = true;
			}
			// If recipe setting is empty/null, default to showing nutrition
			elseif ( empty( $recipe_nutrition ) ) {
				$should_show_nutrition = true;
			}
		}
		
		// If nutrition should be shown, include the template
		if ( $should_show_nutrition ) {
			// Check if we're in the aside hook and nutrition should be on the side
			$current_hook = current_filter();
			if ( $current_hook === 'boorecipe_recipe_single_aside' && $nutrition_side === 'yes' ) {
				$meta_key = 'nutrition';
				include boorecipe_get_template( 'section-recipe-nutrition', 'single' );
			}
			// Check if we're in the main body hook and nutrition should NOT be on the side
			elseif ( $current_hook === 'boorecipe_single_body' && $nutrition_side !== 'yes' ) {
				$meta_key = 'nutrition';
				include boorecipe_get_template( 'section-recipe-nutrition', 'single' );
			}
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
	 * @param object $item A post object
	 * @param array $meta The post metadata
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
	 * @param object $item A post object
	 * @param array $meta The post metadata
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
	 * @param object $item A post object
	 * @param array $meta The post metadata
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

		if ( $this->get_options_value( 'recipe_style' ) !== 'style1' && $this->get_options_value( 'recipe_style' ) !== 'style4' ) {
			return;
		}

		include boorecipe_get_template( 'sub-section-meta-time-style-1', 'single' );

	} //sub_section_single_taxonomy

	/**
	 * sub section meta time - unified for all styles
	 *
	 * @hooked      boorecipe_single_meta        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function sub_section_meta_time( $item, $meta ) {

		include boorecipe_get_template( 'sub-section-meta-time', 'single' );

	} //sub_section_meta_time


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
		$classes_array[] = ( $this->get_options_value( 'show_icons' ) === 'yes' ) ? 'recipe-has-icons' : '';

		return $classes_array;
	}


	/**
	 * filter classes
	 */
	public function add_single_recipe_style_class( $classes ) {

		$classes[] = 'recipe-layout-' . $this->get_options_value( 'recipe_style' );

		return $classes;
	}

	public function add_recipe_style_class( $post_classes ) {

		if ( 'boo_recipe' == get_post_type() ) {

			$post_classes[] = 'single-recipe-body-' . $this->get_options_value( 'recipe_style' );


		}

		return $post_classes;
	}


} // class