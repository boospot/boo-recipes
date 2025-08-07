<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'BoorecipePremiumWidgetRecipeCard' ) ) {
	return;
}

require_once BOORECIPE_BASE_DIR . "includes/class-boorecipe-global-functions.php";


class BoorecipePremiumWidgetRecipeCard extends Boorecipe_Widget_Master {

	public function __construct() {

		$this->widget_cssclass    = 'boorecipe widget_recipe_card';
		$this->widget_description = __( "Single Recipe Card", 'boo-recipes' );
		$this->widget_id          = 'boorecipe_recipe_card';
		$this->widget_name        = __( 'Recipe Card', 'boo-recipes' );
		$this->settings           = array(

			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Featured Recipe', 'boo-recipes' ),
				'label' => __( 'Title', 'boo-recipes' ),
			),

			'recipe_ids' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 0,
				'label' => __( 'Recipe ID to show', 'boo-recipes' ),
			),

			'recipe_archive_layout' => array(
				'type'    => 'select',
				'std'     => 'grid',
				'label'   => _x( 'Layout', 'Sorting order', 'boo-recipes' ),
				'options' => array(
					'grid'   => __( 'Grid', 'boo-recipes' ),
					'modern' => __( 'Modern', 'boo-recipes' ),
				),
			),

			'heading_for_archive_title' => array(
				'type'    => 'select',
				'std'     => $this->get_options_value( 'heading_for_archive_title' ),
				'label'   => _x( 'Heading Tag for Title', 'Sorting order', 'boo-recipes' ),
				'options' => array(
					'h1' => __( 'h1', 'boo-recipes' ),
					'h2' => __( 'h2', 'boo-recipes' ),
					'h3' => __( 'h3', 'boo-recipes' ),
					'h4' => __( 'h4', 'boo-recipes' ),
					'h5' => __( 'h5', 'boo-recipes' ),
					'h6' => __( 'h6', 'boo-recipes' ),
				),
			),

			'color_archive_title' => array(
				'type'  => 'color',
				'std'   => $this->get_options_value( 'color_archive_title' ),
				'label' => __( 'Title Color', 'boo-recipes' ),
			),

			'color_archive_excerpt' => array(
				'type'  => 'color',
				'std'   => $this->get_options_value( 'color_archive_excerpt' ),
				'label' => __( 'Excerpt Color', 'boo-recipes' ),
			),

			'color_card_bg' => array(
				'type'  => 'color',
				'std'   => $this->get_options_value( 'color_card_bg' ),
				'label' => __( 'Card Background Color', 'boo-recipes' ),
			),

			'color_archive_hover_overlay' => array(
				'type'  => 'color',
				'std'   => $this->get_options_value( 'color_archive_hover_overlay' ),
				'label' => __( 'Hover Overlay Color', 'boo-recipes' ),
			),

			'color_archive_keys' => array(
				'type'  => 'color',
				'std'   => $this->get_options_value( 'color_archive_keys' ),
				'label' => __( 'Key Points Color', 'boo-recipes' ),
			),

			'color_archive_key_points_bg' => array(
				'type'  => 'color',
				'std'   => $this->get_options_value( 'color_archive_key_points_bg' ),
				'label' => __( 'Key Points Background Color', 'boo-recipes' ),
			),


			'card_content_alignment' => array(
				'type'    => 'select',
				'std'     => 'center',
				'label'   => _x( 'Content Alignment', 'Text Alignment', 'boo-recipes' ),
				'options' => array(
					'center' => __( 'Center', 'boo-recipes' ),
					'left'   => __( 'Left', 'boo-recipes' ),
					'right'  => __( 'Right', 'boo-recipes' ),
				),
			),

			'show_archive_excerpt' => array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Show Excerpt?', 'boo-recipes' ),
			),

			'show_rounded_card_border' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show rounded Card Borders?', 'boo-recipes' ),
			),

			'card_border_radius_pixels' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 0,
				'max'   => '',
				'std'   => $this->get_options_value( 'card_border_radius_pixels' ),
				'label' => __( 'Border radius in pixels', 'boo-recipes' ),
			),

			'card_border_pixels' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 0,
				'max'   => '',
				'std'   => $this->get_options_value( 'card_border_pixels' ),
				'label' => __( 'Border width in pixels', 'boo-recipes' ),
			),

			'color_card_border' => array(
				'type'  => 'color',
				'std'   => $this->get_options_value( 'color_card_border' ),
				'label' => __( 'Border Color', 'boo-recipes' ),
			),

		);

		parent::__construct();

	}

	protected function get_options_value( $option_id ) {
		return Boorecipe_Globals::get_options_value( $option_id );
	}

	function widget( $args, $instance ) {

		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		$atts = $this->get_single_recipe( $instance );

		extract( $atts );

//		var_dump( $item);

		if ( ! empty( $atts ) && ! is_wp_error( $atts ) ) {
			$this->widget_start( $args, $instance );
			$atts['limit']           = 1;
			$atts['recipes_per_row'] = 1;
			$atts['show_in_masonry'] = 'no';

			echo do_shortcode( "[recipes_browse
				show_in_masonry             ={$atts[ 'show_in_masonry']} 
				recipes_per_row             ={$atts[ 'recipes_per_row']}
				recipe_ids                  ={$atts[ 'recipe_ids']} 
				recipe_archive_layout       ={$atts[ 'recipe_archive_layout']}
				heading_for_archive_title   ={$atts[ 'heading_for_archive_title']}
				color_archive_title         ={$atts[ 'color_archive_title']}
				color_archive_excerpt       ={$atts[ 'color_archive_excerpt']}
				color_card_bg               ={$atts[ 'color_card_bg']}
				color_archive_hover_overlay ={$atts[ 'color_archive_hover_overlay']}
				card_content_alignment      ={$atts[ 'card_content_alignment']}
				color_archive_keys          ={$atts[ 'color_archive_keys']}
				color_archive_key_points_bg ={$atts[ 'color_archive_key_points_bg']}
				show_rounded_card_border    ={$atts[ 'show_rounded_card_border']}
				card_border_radius_pixels   ={$atts[ 'card_border_radius_pixels']}
				card_border_pixels          ={$atts[ 'card_border_pixels']}
				color_card_border           ={$atts[ 'color_card_border']}
				show_archive_excerpt        ={$atts[ 'show_archive_excerpt']}	
				]" );

			$this->widget_end( $args );
		}
//
//		wp_reset_postdata();

		//echo $this->cache_widget( $args, ob_get_clean() ); // WPCS: XSS ok.

	}

	/**
	 * Query the Recipes and return them.
	 *
	 * @param array $instance Widget instance.
	 *
	 * @return array
	 */
	public function get_single_recipe( $instance ) {
		$instance['show_rounded_card_border'] = ! empty( $instance['show_rounded_card_border'] ) ? 'yes' : 'no';
		$instance['show_archive_excerpt']     = ! empty( $instance['show_archive_excerpt'] ) ? 'yes' : 'no';

		// Get the recipe ID from the instance
		$recipe_id = ! empty( $instance['recipe_ids'] ) ? absint( $instance['recipe_ids'] ) : 0;
		
		// If no specific recipe ID is set, get the latest recipe as fallback
		if ( $recipe_id <= 0 ) {
			$latest_recipe = get_posts( array(
				'post_type'      => 'boo_recipe',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'orderby'        => 'date',
				'order'          => 'DESC'
			) );
			
			if ( ! empty( $latest_recipe ) ) {
				$recipe_id = $latest_recipe[0]->ID;
			}
		}

		// We are using id to get the recipe
		$atts = shortcode_atts(
			array(
				'recipe_ids'                  => $recipe_id,
				'enable_ratings'              => $this->get_options_value( 'enable_ratings' ),
				'recipe_archive_layout'       => $this->get_options_value( 'recipe_archive_layout' ),
				'heading_for_archive_title'   => $this->get_options_value( 'heading_for_archive_title' ),
				'color_archive_title'         => $this->get_options_value( 'color_archive_title' ),
				'color_archive_excerpt'       => $this->get_options_value( 'color_archive_excerpt' ),
				'color_card_bg'               => $this->get_options_value( 'color_card_bg' ),
				'color_archive_hover_overlay' => $this->get_options_value( 'color_archive_hover_overlay' ),
				'card_content_alignment'      => $this->get_options_value( 'card_content_alignment' ),
				'color_archive_keys'          => $this->get_options_value( 'color_archive_keys' ),
				'color_archive_key_points_bg' => $this->get_options_value( 'color_archive_key_points_bg' ),
				'show_rounded_card_border'    => $this->get_options_value( 'show_rounded_card_border' ),
				'card_border_radius_pixels'   => $this->get_options_value( 'card_border_radius_pixels' ),
				'card_border_pixels'          => $this->get_options_value( 'card_border_pixels' ),
				'color_card_border'           => $this->get_options_value( 'color_card_border' ),
				'show_archive_excerpt'        => $this->get_options_value( 'show_archive_excerpt' ),
			),
			$instance
		);

		return $atts;
	}


}