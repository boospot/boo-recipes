<?php /** @noinspection PhpUnusedLocalVariableInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Premium_Shortcodes' ) ) {
	return;
}
// Require the class file from parent plugin as the premium class is extending that class
require_once BOORECIPE_PREMIUM_PARENT_BASE_DIR . 'includes/class-boorecipe-shortcodes.php';

/**
 * Class Boorecipe_Premium_Shortcodes
 *
 * This class will extend the functionality of the main class defined in base version of plugin
 */
class Boorecipe_Premium_Shortcodes extends Boorecipe_Shortcodes {

	/**
	 *
	 * @param $atts
	 *
	 * @hooked recipe_embed shortcode registered
	 *
	 * @return mixed
	 * @since    1.0.0
	 *
	 */
	public function recipe_embed( $atts ) {


		$atts = shortcode_atts(
			array(
				'id'                       => '',
				'recipe_style'             => 'style1',
				'color_accent'             => $this->get_options_value( 'color_accent' ),
				'color_secondary'          => $this->get_options_value( 'color_secondary' ),
				'color_icon'               => $this->get_options_value( 'color_icon' ),
				'color_border'             => $this->get_options_value( 'color_border' ),
				'show_nutrition'           => $this->get_options_value( 'show_nutrition' ),
				'show_icons'               => $this->get_options_value( 'show_icons' ),
				'ingredient_side'          => $this->get_options_value( 'ingredient_side' ),
				'nutrition_side'           => $this->get_options_value( 'nutrition_side' ),
				'enable_ratings'           => $this->get_options_value( 'enable_ratings' ),
				'show_share_buttons'       => $this->get_options_value( 'show_share_buttons' ),
				'show_author'              => $this->get_options_value( 'show_author' ),
				'show_author_box'          => $this->get_options_value( 'show_author_box' ),
				'recipe_author_link_label' => $this->get_options_value( 'recipe_author_link_label' ),
				'show_published_date'      => $this->get_options_value( 'show_published_date' ),
				'featured_image_height'    => $this->get_options_value( 'featured_image_height' ),
				'related_recipes_show'     => 'no',
				'recipe_layout'            => 'full',
				'recipe_image_slider'      => 'yes'
			),
			$atts,
			'recipe_embed'
		);
		
//		var_dump_pretty( $atts);

		$this->setup_shortcode_data( $atts, 'recipe_embed', 'single' );

		$recipe_id = absint( $atts['id'] );

		if ( ! $recipe_id ) {
			return sprintf( '<div class="error notice notice-danger notice-error">%s</div>', __( "Please provide a valid recipe id.", 'boorecipe-premium' ));
		}
		$query_args = array(
			'post_type'   => 'boo_recipe',
			'post_status' => 'publish',
			'p'           => $recipe_id,
		);

		$loop = new WP_Query( $query_args );

		ob_start();

		include boorecipe_get_template( "recipe-embed", 'shortcodes' );

		$this->reset_shortcode_data();

		return ob_get_clean();


	}

	/**
	 * @param $atts
	 *
	 * Css for recipe_embed shortcode
	 */
	public function add_shortcode_css_recipe_embed( $atts ) {

		$prefix_class = $this->get_prefix_class();

		add_filter( 'boorecipe_single_recipe_post_classes', array( $this, 'set_prefix_class' ) );

		$accent_color    = boorecipe_sanitize_color( $atts['color_accent'] );
		$secondary_color = boorecipe_sanitize_color( $atts['color_secondary'] );
		$icon_color      = boorecipe_sanitize_color( $atts['color_icon'] );
		$border_color    = boorecipe_sanitize_color( $atts['color_border'] );
		$image_height    = absint( $atts['featured_image_height'] );


		$css = '';
		$css .= ".$prefix_class .recipe-title {color: {$accent_color};}";

		$css .= ".$prefix_class .recipe-single-instruction:before {background-color: {$secondary_color}; color: {$accent_color};}";

		$css .= ".$prefix_class .ingredient-side .recipe-ingredients {background: {$secondary_color};}";

		$css .= ".$prefix_class .subsection-label {color: {$accent_color};font-style: italic;}";

		$css .= ".$prefix_class .slider-thumbs-section {background-color: {$secondary_color};}";

		$css .= ".$prefix_class .recipe-time-info, .recipe-taxonomy, .recipe-key-points {border-top: 1px dashed {$border_color};}";

		$css .= ".$prefix_class .recipe-key-points {border-bottom: 1px solid {$border_color};margin-bottom: 1em;}";

		$css .= ".$prefix_class .subsection-icon {color: {$icon_color};}";

		$css .= ".$prefix_class .posttype-section.recipe-img-cont {max-height: {$image_height}px;overflow: hidden;justify-content: center;}";

		$css .= ".$prefix_class .select-items-cont .select-item.active::before {background-color: {$accent_color};opacity: 0.5;}";

		$css .= "";

		$this->add_shortcode_css( $css );

	}

	/**
	 * @param $atts
	 *
	 * @return $atts (modified)
	 *
	 * Options to add in shortcode that are only available in premium version
	 */
	public function filter_shortcode_atts_recipes_browse_array( $atts ) {

		$new_atts = array(

			'color_archive_key_points_bg'  => $this->get_options_value( 'color_archive_key_points_bg' ),
			'color_archive_hover_overlay'  => $this->get_options_value( 'color_archive_hover_overlay' ),
			'card_content_alignment'       => $this->get_options_value( 'card_content_alignment' ),
			'color_archive_keys'           => $this->get_options_value( 'color_archive_keys' ),
			'show_rounded_card_border'     => $this->get_options_value( 'show_rounded_card_border' ),
			'card_border_radius_pixels'    => $this->get_options_value( 'card_border_radius_pixels' ),
			'card_border_pixels'           => $this->get_options_value( 'card_border_pixels' ),
			'color_card_border'            => $this->get_options_value( 'color_card_border' ),
			'recipe_cuisine_ids'           => '',
			'recipe_cuisine_slugs'         => '',
			'recipe_cuisine_ids_exclude'   => '',
			'recipe_cuisine_slugs_exclude' => '',
			'cooking_method_ids'           => '',
			'cooking_method_slugs'         => '',
			'cooking_method_ids_exclude'   => '',
			'cooking_method_slugs_exclude' => '',


		);

		return array_merge( $atts, $new_atts );

	}

}