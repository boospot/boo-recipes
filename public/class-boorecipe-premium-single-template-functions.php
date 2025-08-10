<?php
/** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection PhpUnusedParameterInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Premium_Single_Template_Functions' ) ) {
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
require_once BOORECIPE_BASE_DIR . 'public/class-boorecipe-single-template-functions.php';

if ( ! class_exists( 'Boorecipe_Single_Template_Functions' ) ) {
	return;
}

/**
 * For Premium Single Template Functions
 * Class Boorecipe_Premium_Single_Template_Functions
 */
class Boorecipe_Premium_Single_Template_Functions extends Boorecipe_Single_Template_Functions {

	/**
	 * @hooked      boorecipe_single_meta        10
	 *
	 * @param bool $is_video_or_slider default false
	 * @param array $meta
	 *
	 * @return bool $is_video_or_slider
	 */
	public function is_recipe_have_video_or_image( $is_video_or_slider, $meta ) {
		// if the recipe have attached media, it mean we are using slider and not the featured image
		if ( $this->is_show_image_slider( $meta ) || $this->is_video_recipe( $meta ) ) {
			$is_video_or_slider = true;
		}

		return $is_video_or_slider;
	}

	/**
	 *
	 * Include      public/templates/single/recipe-image-slider
	 *
	 * @hooked      boorecipe_single_media        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function recipe_image_slider( $item, $meta ) {


		if ( ! $this->is_show_image_slider( $meta ) ) {
			return;
		}

		include boorecipe_get_template( 'recipe-image-slider', 'single' );

	}

	/**
	 *
	 * Include      public/templates/single/recipe-video-section
	 *
	 * @hooked      boorecipe_single_media        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function recipe_video_section( $item, $meta ) {

		if ( ! $this->is_video_recipe( $meta ) ) {
			return;
		}

		include boorecipe_get_template( 'recipe-video-section', 'single' );

	}


	/**
	 *
	 * Include      public/templates/single/section-recipe-tool
	 *
	 * @hooked      boorecipe_single_body        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function recipe_tool_display( $item, $meta ) {

		include boorecipe_get_template( 'section-recipe-tool', 'single' );

	}

	/**
	 *
	 * Include      public/templates/single/section-cooking-method
	 *
	 * @hooked      boorecipe_single_body        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function cooking_methods_display( $item, $meta ) {

		if ( 'yes' !== $this->get_options_value( 'show_cooking_method_img' ) ) {
			return null;
		}


		include boorecipe_get_template( 'section-cooking-method', 'single' );

	}

	/**
	 * Include      public/templates/single/sub-section-meta-key-point-style-2
	 *
	 * @hooked      boorecipe_single_meta        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function sub_section_meta_key_point_style_2( $item, $meta ) {

		if ( $this->get_options_value( 'recipe_style' ) != 'style1' ) {
			include boorecipe_get_template( 'sub-section-meta-key-point-style-2', 'single' );
			// this is calling action: boorecipe_single_meta_key_point_style_2

		}

	}


	/*
	 * Include      public/templates/single/sub-section-meta-taxonomy-style-2-entry
	 *
	 * @hooked      boorecipe_single_meta_key_point_style_2        15
	 *
	 * @param object $item
	 * @param array $meta
	 */

	public function the_taxonomy_category_style_2( $item, $meta ) {

		$taxonomy       = 'recipe_category';
		$taxonomy_label = $this->get_taxonomy_label( $taxonomy );
		$taxonomy_terms = $this->get_taxonomy_terms( $item->ID, $taxonomy );

		$itemprop = 'recipeCategory';

		if ( ! empty( $taxonomy_terms ) ) {
			include boorecipe_get_template( 'sub-section-meta-taxonomy-style-2-entry', 'single' );
		}


	}


	/*
	 * Include      public/templates/single/sub-section-meta-taxonomy-style-2-entry
	 *
	 * @hooked      boorecipe_single_meta_key_point_style_2        15
	 *
	 * @param object $item
	 * @param array $meta
	 */

	public function the_taxonomy_cuisine_style_2( $item, $meta ) {

		$taxonomy       = 'recipe_cuisine';
		$taxonomy_label = $this->get_taxonomy_label( $taxonomy );
		$taxonomy_terms = $this->get_taxonomy_terms( $item->ID, $taxonomy );

		$itemprop = 'recipeCuisine';

		if ( ! empty( $taxonomy_terms ) ) {
			include boorecipe_get_template( 'sub-section-meta-taxonomy-style-2-entry', 'single' );
		}


	}

	/*
	 * Include      public/templates/single/sub-section-meta-taxonomy-style-2-entry
	 *
	 * @hooked      boorecipe_single_meta_key_point_style_2        15
	 *
	 * @param object $item
	 * @param array $meta
	 */

	public function the_taxonomy_tags_style_2( $item, $meta ) {

		$taxonomy       = 'recipe_tags';
		$taxonomy_label = $this->get_taxonomy_label( $taxonomy );
		$taxonomy_terms = $this->get_taxonomy_terms( $item->ID, $taxonomy );

		$itemprop = 'keywords';

		if ( ! empty( $taxonomy_terms ) ) {
			include boorecipe_get_template( 'sub-section-meta-taxonomy-style-2-entry', 'single' );
		}
	}

	/*
	 * Include      public/templates/single/sub-section-meta-taxonomy-style-2-entry
	 *
	 * @hooked      boorecipe_single_meta_key_point_style_2        15
	 *
	 * @param object $item
	 * @param array $meta
	 */

	public function the_taxonomy_skill_level_style_2( $item, $meta ) {

		$taxonomy       = 'skill_level';
		$taxonomy_label = $this->get_taxonomy_label( $taxonomy );
		$taxonomy_terms = $this->get_taxonomy_terms( $item->ID, $taxonomy );

		$itemprop = '';

		if ( ! empty( $taxonomy_terms ) ) {
			include boorecipe_get_template( 'sub-section-meta-taxonomy-style-2-entry', 'single' );
		}

	} // the_taxonomy_skill_level_style_2()


	/**
	 * Include      public/templates/single/sub-section-meta-taxonomy-style-2-entry
	 *
	 * @hooked      boorecipe_single_meta_key_point_style_2        15
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function key_point_yields_style_2( $item, $meta ) {
		$key_point = 'yields';
		$itemprop  = 'recipeYield';

		$key_point_label = $this->get_options_value( $key_point . '_label' );
		$key_point_value = isset( $meta[ $key_point ] ) ? $meta[ $key_point ] : false;

		if ( $meta[ $key_point ] ) {
			include boorecipe_get_template( 'sub-section-meta-key-point-style-2-entry', 'single' );
		}

	} // key_point_yields_style_2()


	/**
	 * Include time display for premium styles (positioned in body_before)
	 *
	 * @hooked      boorecipe_single_body_before        9
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function sub_section_meta_time_style_2( $item, $meta ) {

		if ( $this->get_options_value( 'recipe_style' ) != 'style1' ) {
			// Use the unified time template for premium styles
			include boorecipe_get_template( 'sub-section-meta-time', 'single' );
		}

	} //sub_section_meta_time_style_2


	/**
	 * Include      public/templates/single/sub-section-meta-taxonomy-style-2-entry
	 *
	 * @hooked      boorecipe_single_body_before        9
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function the_taxonomy_cooking_method_style_2( $item, $meta ) {

		$taxonomy       = 'cooking_method';
		$taxonomy_label = $this->get_taxonomy_label( $taxonomy );
		$taxonomy_terms = $this->get_taxonomy_terms( $item->ID, $taxonomy );

		$itemprop = 'cookingMethod';

		if ( ! empty( $taxonomy_terms ) ) {
			include boorecipe_get_template( 'sub-section-meta-taxonomy-style-2-entry', 'single' );
		}


	} // the_taxonomy_cooking_method_style_2


	/**
	 * Include      public/templates/single/section-share-buttons
	 *
	 * @hooked      boorecipe_single_body_before        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function section_sharing_buttons_style_2( $item, $meta ) {

		if ( $this->get_options_value( 'recipe_style' ) !== 'style2' ) {
			return;
		}

		if ( $this->get_options_value( 'show_share_buttons' ) === 'yes' ):
			$image_size         = $this->get_options_value( 'recipe_image_size' );
			$featured_image_url = get_the_post_thumbnail_url( $item->ID, $image_size );
			//Assign default if empty
			if ( empty( $featured_image_url ) ) {
				$featured_image_url = $this->get_recipe_featured_image_default();
			}

			$title   = urlencode( $item->post_title );
			$excerpt = ( ! empty( trim( $item->post_excerpt ) ) ) ? $item->post_excerpt : substr( $meta['short_description'], 0, 145 ) . "...";

			include boorecipe_get_template( 'section-share-buttons', 'single' );

		endif;

	} // section_sharing_buttons_style_2()


	/**
	 * Include      public/templates/single/sub-section-meta-taxonomy-entry
	 *
	 * @hooked      boorecipe_single_media        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function the_taxonomy_cuisine( $item, $meta ) {

		$taxonomy       = 'recipe_cuisine';
		$taxonomy_label = $this->get_taxonomy_label( $taxonomy );
		$taxonomy_terms = $this->get_taxonomy_terms( $item->ID, $taxonomy );

		$itemprop = 'recipeCuisine';

		if ( ! empty( $taxonomy_terms ) ) {
			include boorecipe_get_template( 'sub-section-meta-taxonomy-entry', 'single' );
		}

	}

	/**
	 * Include      public/templates/single/sub-section-meta-taxonomy-entry
	 *
	 * @hooked      boorecipe_single_meta_key_point        15
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function the_taxonomy_cooking_method( $item, $meta ) {

		if ( 'no' !== $this->get_options_value( 'show_cooking_method_img' ) ) {
			return null;
		}

		$taxonomy       = 'cooking_method';
		$taxonomy_label = $this->get_taxonomy_label( $taxonomy );
		$taxonomy_terms = $this->get_taxonomy_terms( $item->ID, $taxonomy );

		$itemprop = 'cookingMethod';

		if ( ! empty( $taxonomy_terms ) ) {
			include boorecipe_get_template( 'sub-section-meta-taxonomy-entry', 'single' );
		}

	}


	/**
	 * Include      public/templates/single/sub-section-author-box
	 *
	 * @hooked      boorecipe_single_body_after        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function ratings_display( $item, $meta ) {
		if ( $this->get_options_value( 'enable_ratings' ) !== 'yes' ) {
			return;
		}

		$meta_key = 'boorecipe_user_rating';

		include boorecipe_get_template( 'sub-section-ratings-display', 'single' );

	}


	/**
	 * Include      public/templates/single/sub-section-author-box
	 *
	 * @hooked      boorecipe_single_body_after        11
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function author_box( $item, $meta ) {

		if ( $this->get_options_value( 'show_author_box' ) !== 'yes' ) {
			return;
		}
		include boorecipe_get_template( 'sub-section-author-box', 'single' );
	} // author_box()


	/**
	 * Include      public/templates/single/section-related-recipes
	 *
	 * @hooked      boorecipe_single_body_after        11
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function related_recipes_section( $item, $meta ) {

		if ( $this->get_options_value( 'related_recipes_show' ) != 'yes' ) {
			return;
		}
		include boorecipe_get_template( 'section-related-recipes', 'single' );

	}


	/**
	 *
	 * @hooked      boorecipe_single_media_before        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function single_media_before( $item, $meta ) {

		$hook_option = $this->get_options_value( 'single_media_before' );
		if ( ! empty( $hook_option ) ) {
			echo do_shortcode( $hook_option );
		}

	}


	/**
	 *
	 * @hooked      boorecipe_single_media_after        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function single_media_after( $item, $meta ) {

		$hook_option = $this->get_options_value( 'single_media_after' );
		if ( ! empty( $hook_option ) ) {
			echo do_shortcode( $hook_option );
		}

	}


	/**
	 *
	 * @hooked      boorecipe_single_head_before        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function single_head_before( $item, $meta ) {

		$hook_option = $this->get_options_value( 'single_head_before' );
		if ( ! empty( $hook_option ) ) {
			echo do_shortcode( $hook_option );
		}

	}

	/**
	 *
	 * @hooked      boorecipe_single_head_after        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function single_head_after( $item, $meta ) {

		$hook_option = $this->get_options_value( 'single_head_after' );
		if ( ! empty( $hook_option ) ) {
			echo do_shortcode( $hook_option );
		}

	}

	/**
	 *
	 * @hooked      boorecipe_single_meta_before        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function single_meta_before( $item, $meta ) {

		$hook_option = $this->get_options_value( 'single_meta_before' );
		if ( ! empty( $hook_option ) ) {
			echo do_shortcode( $hook_option );
		}

	}

	/**
	 *
	 * @hooked      boorecipe_single_meta_after        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function single_meta_after( $item, $meta ) {

		$hook_option = $this->get_options_value( 'single_meta_after' );
		if ( ! empty( $hook_option ) ) {
			echo do_shortcode( $hook_option );
		}

	}


	/**
	 *
	 * @hooked      boorecipe_single_body_before        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function single_body_before( $item, $meta ) {

		$hook_option = $this->get_options_value( 'single_body_before' );
		if ( ! empty( $hook_option ) ) {
			echo do_shortcode( $hook_option );
		}

	}

	/**
	 *
	 * @hooked      boorecipe_single_body_after        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function single_body_after( $item, $meta ) {

		$hook_option = $this->get_options_value( 'single_body_after' );
		if ( ! empty( $hook_option ) ) {
			echo do_shortcode( $hook_option );
		}

	}

	/**
	 *
	 * @hooked      boorecipe_single_article_before_start        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function single_article_before_start( $item, $meta ) {

		$hook_option = $this->get_options_value( 'single_article_before_start' );
		if ( ! empty( $hook_option ) ) {
			echo do_shortcode( $hook_option );
		}

	}


	/**
	 *
	 * @hooked      boorecipe_single_article_after_end        10
	 *
	 * @param object $item
	 * @param array $meta
	 */
	public function single_article_after_end( $item, $meta ) {

		$hook_option = $this->get_options_value( 'single_article_after_end' );
		if ( ! empty( $hook_option ) ) {
			echo do_shortcode( $hook_option );
		}

	}


	/**
	 * Classes for recipe layout
	 */
	public function single_recipe_layout_class( $classes ) {

		$classes[] = 'recipe-' . $this->get_options_value( 'recipe_style' );

		return $classes;
	}

	/**
	 * Add recipe style class to meta section
	 */
	public function add_recipe_meta_style_class( $classes ) {

		$style = $this->get_options_value( 'recipe_style' );
		if ( $style ) {
			$classes[] = 'recipe-style' . $style;
		}

		return $classes;
	}


	public function add_boo_recipe_details_wrapper() {

		if ( 'style3' == $this->get_options_value( 'recipe_style' ) || 'style4' == $this->get_options_value( 'recipe_style' ) ) {
			?>
            <div class="boo-recipe-details-wrapper">
			<?php
		}


	}


	public function close_boo_recipe_details_wrapper() {

		if ( 'style3' == $this->get_options_value( 'recipe_style' ) || 'style4' == $this->get_options_value( 'recipe_style' ) ) {
			?>
            </div>
			<?php
		}


	}

} // class