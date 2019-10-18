<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Shortcodes' ) ) {
	return;
}

/**
 * Class Boorecipe_Shortcodes
 */
class Boorecipe_Shortcodes {

	/**
	 * Private static reference to this class
	 * Useful for removing actions declared here.
	 *
	 * @var    object $_this
	 */
	protected static $_this;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	protected $version;

	/**
	 * @var bool
	 */
	protected $style_enqueued = false;

	/**
	 * @var null|array $shortcode_atts
	 */
	protected $shortcode_atts;

	/**
	 * @var string $shortcode_css
	 */
	protected $shortcode_css;

	/**
	 * @var int
	 */
	protected $shortcode_counter = 1;

	/**
	 * @var string
	 */
	protected $shortcode_called = '';

	/**
	 * @var array
	 */
	protected $shortcodes_registered = array();

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 *
	 */
	public function __construct( $plugin_name, $version ) {

		self::$_this = $this;

		$this->plugin_name    = $plugin_name;
		$this->version        = $version;
		$this->shortcode_atts = null;

	} // __construct

	/**
	 * Registering a style so that we may populate it with wp_inline_style later
	 * for displaying shortcode related configurable css
	 */
	public function register_styles() {

		wp_register_style( $this->plugin_name . '-shortcodes', false );

	}

	/**
	 * @return bool|string
	 */
	public function boorecipe_search_form() {

//		if ( $this->get_options_value( 'show_search_form' ) === 'yes' && ! boorecipe_is_search_form_submitted() ) :

		ob_start();

		include boorecipe_get_template( 'search-form', 'widgets' );

		return ob_get_clean();
//
//		else:
//
//			return false;
//
//		endif;


	}

	/**
	 * @param $atts
	 *
	 * @return string
	 */
	public function boorecipe_print_button( $atts ) {

		$args = shortcode_atts(
			array(
				'text'  => __( 'Print', 'boorecipe' ),
				'align' => ''
			),
			$atts
		);

		$print_icon = Boorecipe_Globals::get_svg( 'print', 'icon-size-' . $this->get_options_value( 'general_icon_size' ) );

		return "<a class='boorecipe-print-link' style = 'text-align:{$args['align']}' href='javascript:window.print()'>{$print_icon} {$args['text']}</a>";
	}

	/**
	 * @param $option_id
	 *
	 * @return bool|mixed
	 */
	protected function get_options_value( $option_id ) {
		return Boorecipe_Globals::get_options_value( $option_id );
	}

	/**
	 * @param $options_array
	 *
	 * @return array
	 */
	public function override_options_value_for_shortcodes( $options_array ) {

		if ( $this->shortcode_atts === null ) {
			return $options_array;
		}

		$shortcode_atts = $this->shortcode_atts;

		/*
		 * Loop Method
		 */
//		foreach ( $options_array as $key => $value ) {
//
//			if ( isset( $shortcode_atts[ $key ] ) ) {
//				$options_array[ $key ] = $shortcode_atts[ $key ];
//			} else {
//				continue;
//			}
//
//		}


		/*
		 * Shortcode_atts method
		 */
//		$options_array = shortcode_atts(
//			$options_array,
//			$shortcode_atts
//		);

		/*
		 * wp_parse_args() method
		 */
		$options_array = wp_parse_args( $shortcode_atts, $options_array );

		return $options_array;

	}

	/**
	 * @param $options_array
	 *
	 * @return array
	 */
	public function inactive_override_single_option_value_for_shortcodes( $get_options_value, $option_id ) {


		$options_array = array(
			$option_id => $get_options_value
		);


		if ( $this->shortcode_atts === null ) {
			return $options_array;
		}

		$shortcode_atts = $this->shortcode_atts;

		/*
		 * Loop Method
		 */
//		foreach ( $options_array as $key => $value ) {
//
//			if ( isset( $shortcode_atts[ $key ] ) ) {
//				$options_array[ $key ] = $shortcode_atts[ $key ];
//			} else {
//				continue;
//			}
//
//		}


		/*
		 * Shortcode_atts method
		 */
//		$options_array = shortcode_atts(
//			$options_array,
//			$shortcode_atts
//		);

		/*
		 * wp_parse_args() method
		 */

		$options_array = wp_parse_args( $shortcode_atts, $options_array );

		return $options_array[ $option_id ];

	}


	/**
	 * @param $atts
	 *
	 * @hooked recipes_browse shortcode registered
	 *
	 * @return mixed
	 */
	public function recipes_browse( $atts ) {

		$atts = shortcode_atts(
			apply_filters( 'shortcode_atts_recipes_browse_array', array(
				'limit'                     => $this->get_options_value( 'recipes_per_page' ),
				'enable_ratings'            => $this->get_options_value( 'enable_ratings' ),
				'recipes_per_row'           => $this->get_options_value( 'recipes_per_row' ),
				'recipe_archive_layout'     => $this->get_options_value( 'recipe_archive_layout' ),
				'show_in_masonry'           => $this->get_options_value( 'show_in_masonry' ),
				'heading_for_archive_title' => $this->get_options_value( 'heading_for_archive_title' ),
				'color_archive_title'       => $this->get_options_value( 'color_archive_title' ),
				'color_archive_excerpt'     => $this->get_options_value( 'color_archive_excerpt' ),
				'color_card_bg'             => $this->get_options_value( 'color_card_bg' ),

				'show_archive_excerpt' => $this->get_options_value( 'show_archive_excerpt' ),

				'recipe_ids'         => '',
				'recipe_ids_exclude' => '',

				'recipe_category_ids'           => '',
				'recipe_category_slugs'         => '',
				'recipe_category_ids_exclude'   => '',
				'recipe_category_slugs_exclude' => '',


				'recipe_tags_ids'           => '',
				'recipe_tags_slugs'         => '',
				'recipe_tags_ids_exclude'   => '',
				'recipe_tags_slugs_exclude' => '',

				'skill_level_ids'           => '',
				'skill_level_slugs'         => '',
				'skill_level_ids_exclude'   => '',
				'skill_level_slugs_exclude' => '',


			) ),
			$atts,
			'recipes_browse'
		);


		$this->setup_shortcode_data( $atts, 'recipes_browse', 'archive' );


		if ( sanitize_key( $atts['show_in_masonry'] ) === 'yes' ) {
			wp_enqueue_script( 'masonry' );
		}


		$query_args = array(
			'post_type'      => 'boo_recipe',
			'post_status'    => 'publish',
			'posts_per_page' => absint( $atts['limit'] ),
		);

		$query_args = $this->setup_posts_query_with_shortcode_atts( $query_args, $atts );

		$loop = new WP_Query( $query_args );


		$archive_layout = sanitize_key( $atts['recipe_archive_layout'] );


		// $archive_template is required in included file
		$archive_template = ( is_file( boorecipe_get_template( "archive-recipe-content-{$archive_layout}", 'archive' ) ) )

			? boorecipe_get_template( "archive-recipe-content-{$archive_layout}", 'archive' )
			: boorecipe_get_template( "archive-recipe-content-grid", 'archive' );

		ob_start();

		include boorecipe_get_template( "recipes-browse", 'shortcodes' );

		$this->reset_shortcode_data();

		return ob_get_clean();

	}

	/**
	 * @param $shortcode_atts array shortcode attributes array
	 * @param $shortcode_name string shortcode name
	 * @param $shortcode_type string single|archive|mixed
	 */
	protected function setup_shortcode_data( $shortcode_atts, $shortcode_name, $shortcode_type ) {

		$this->shortcode_atts   = $shortcode_atts;
		$this->shortcode_called = $shortcode_name;

		add_filter( 'boorecipe_options_array_from_db', array( $this, 'override_options_value_for_shortcodes' ) );
//		add_filter( 'boorecipe_option_from_db', array( $this, 'override_single_option_value_for_shortcodes' ), 10, 2 );
//
		add_filter( 'boorecipe_filter_archive_recipe_wrap_classes', array(
			$this,
			'filter_archive_recipe_wrap_classes'
		) );
//
//
		add_filter( 'boorecipe_filter_archive_recipe_card_classes', array(
			$this,
			'filter_archive_recipe_card_classes'
		) );

		// Check to see if CSS related method exists
		if ( method_exists( $this, "add_shortcode_css_{$shortcode_name}" ) ) {

			// Call the method to add CSS
			call_user_func_array( array( $this, "add_shortcode_css_{$shortcode_name}" ), array( $shortcode_atts ) );

			// Enqueue added CSS
			$this->enqueue_shortcode_style();

		}


		// So that we can keep track of which shortcodes registered
		Boorecipe_Globals::register_shortcode( $shortcode_name, $shortcode_type );


	}

	/**
	 * USed to enqueue style already registered
	 */
	protected function enqueue_shortcode_style() {


		if ( ! empty( $this->shortcode_css ) ) {
			if ( ! $this->is_already_enqueued() ) {
				wp_enqueue_style( $this->plugin_name . '-shortcodes' );
				$this->style_enqueued = true;
			}
		}

	}

	/**
	 * @return bool
	 */
	protected function is_already_enqueued() {

		return ( $this->style_enqueued ) ? true : false;

	}

	/**
	 * @param array $query_args
	 * @param array $atts
	 *
	 * @return array $query_args
	 */
	protected function setup_posts_query_with_shortcode_atts( $query_args, $atts ) {

		// array of possible query modifiers in shortcode atts
		$possible_query_modifier_args = array(

			'recipe_ids'         => '',
			'recipe_ids_exclude' => '',

			'recipe_category_ids'           => '',
			'recipe_category_slugs'         => '',
			'recipe_category_ids_exclude'   => '',
			'recipe_category_slugs_exclude' => '',

			'recipe_cuisine_ids'           => '',
			'recipe_cuisine_slugs'         => '',
			'recipe_cuisine_ids_exclude'   => '',
			'recipe_cuisine_slugs_exclude' => '',

			'recipe_tags_ids'           => '',
			'recipe_tags_slugs'         => '',
			'recipe_tags_ids_exclude'   => '',
			'recipe_tags_slugs_exclude' => '',

			'skill_level_ids'           => '',
			'skill_level_slugs'         => '',
			'skill_level_ids_exclude'   => '',
			'skill_level_slugs_exclude' => '',

			'cooking_method_ids'           => '',
			'cooking_method_slugs'         => '',
			'cooking_method_ids_exclude'   => '',
			'cooking_method_slugs_exclude' => '',
		);

		/*
		 * try to get modifiers used in the query args
		 */

		// initialize array
		$query_modifiers_in_shortcode = array();

		// populate array
		foreach ( $possible_query_modifier_args as $key => $value ) {
			if ( isset( $atts[ $key ] ) && ! empty( $atts[ $key ] ) ) {
				$query_modifiers_in_shortcode[ $key ] = $atts[ $key ];
			}
		}

		// If no args provided for query modifier, bail out early and return original $args
		if ( empty( $query_modifiers_in_shortcode ) ) {
			return $query_args;
		}


		// Loop through the $query_modifiers_in_shortcode to update $query_args
		foreach ( $query_modifiers_in_shortcode as $property => $value ) :

			// Detect the query modifier type ( post / taxonomy etc. )
			$parameter_type = $this->detect_parameter_type( $property );
			$parts          = explode( '_', $property );

			// update $query_args for $parameter_type: post
			if ( $parameter_type === 'post' ):

				$posts_array = $key_value = '';

				// Get $field, $terms and $operator
				switch ( end( $parts ) ) {
					case ( 'ids' ):
						$posts_array = boorecipe_get_array_from_csv( $value );
						$key_value   = 'post__in';
						break;

					case ( 'exclude' ):
						$posts_array = boorecipe_get_array_from_csv( $value );
						$key_value   = 'post__not_in';
						break;

					default :
				}


				// Using the parameters to update $query_args
				if ( ! empty( $posts_array ) ) {
					$query_args[ $key_value ] = $posts_array;
				}

				continue;    // continue of foreach as we are done for this $parameter_type
			endif; //$parameter_type === 'taxonomy'

			// update $query_args for $parameter_type: taxonomy
			if ( $parameter_type === 'taxonomy' ):
				// Now we need to get the following 4 vars from this array elements
				//			$taxonomy = '';
				//			$field    = '';
				//			$terms    = '';
				//			$operator = '';

				// Setting default $operator
				$taxonomy = '';
				// if exclude not found, then operator is IN
				$operator = 'IN';


				// Get $taxonomy
				switch ( $parts[1] ) {

					case ( 'category' ):
						$taxonomy = 'recipe_category';
						break;
					case ( 'cuisine' ):
						$taxonomy = 'recipe_cuisine';
						break;
					case ( 'tags' ):
						$taxonomy = 'recipe_tags';
						break;
					case ( 'level' ):
						$taxonomy = 'skill_level';
						break;
					case ( 'method' ):
						$taxonomy = 'cooking_method';
						break;
					default:

				}

				// Get $field, $terms and $operator
				switch ( end( $parts ) ) {
					case ( 'ids' ):
						$field = 'term_id';
						$terms = boorecipe_get_array_from_csv( $value );

						break;
					case ( 'slugs' ):
						$field = 'slug';
						$terms = boorecipe_get_array_from_slugs_csv( $value );
						break;

					case ( 'exclude' ):
						$operator = 'NOT IN';
						switch ( $parts[2] ) {
							case ( 'ids' ):
								$field = 'term_id';
								$terms = boorecipe_get_array_from_csv( $value );
								break;
							case ( 'slugs' ):
								$field = 'slug';
								$terms = boorecipe_get_array_from_slugs_csv( $value );
								break;
							default:
								$field = '';
						}

						break;

					default:

						$field = '';
				}

				// Using these 4 args for Taxonomy to update $query_args
				if ( ! empty( $terms ) ) {
					$query_args['tax_query'][] = array(
						'taxonomy' => $taxonomy,
						'field'    => $field,
						'terms'    => $terms,
						'operator' => $operator,
					);

				}

				continue; // break out of foreach
			endif; //$parameter_type === 'taxonomy'

		endforeach;

		return $query_args;

	}

	/**
	 * @param $property
	 *
	 * @return string 'post' or 'taxonomy'
	 */
	protected function detect_parameter_type( $property ) {

		$parts = explode( '_', $property );

		// Detect the query modifier type ( Post / Taxonomy etc. )
		switch ( $parts[1] ) {
			case ( 'ids' ) :
				$parameter_type = 'post';
				break;
			default:
				$parameter_type = 'taxonomy';

		}

		return $parameter_type;
	}

	/**
	 * reset the shortcode relate data to get ready for next shortcode added
	 *
	 * also check setup_shortcode_data()
	 *
	 */
	protected function reset_shortcode_data() {
		$this->shortcode_atts   = null;
		$this->shortcode_called = '';

		// To keep track of counter
		$this->shortcode_counter ++;
	}

	/**
	 *
	 */
	public function filter_archive_recipe_wrap_classes( $classes_array ) {

//		if ( 'recipes_browse' != $this->shortcode_called ) {
//			return null;
//		}
		$recipe_archive_layout = $this->shortcode_atts['recipe_archive_layout'];

		$classes_array['layout'] = 'recipes-layout-' . $recipe_archive_layout;


		if ( $this->shortcode_atts['show_in_masonry'] === 'yes' ) {
			$classes_array['masonry'] = 'masonry-grid';
		}

		$recipes_per_row = $this->shortcode_atts['recipes_per_row'];

		$classes_array['per_row'] = 'per-row-' . sanitize_html_class( $recipes_per_row );

		return $classes_array;

	}

	/**
	 * @param $classes_array
	 *
	 * @return mixed
	 */
	public function set_prefix_class( $classes_array ) {

		$classes_array["{$this->shortcode_called}_shortcode_counter"] = $this->get_prefix_class();

		return $classes_array;
	}

	/**
	 * @return string
	 */
	protected function get_prefix_class() {

		$prefix_class = $this->shortcode_called . "-" . $this->shortcode_counter;

		return $prefix_class;
	}

	/**
	 *
	 */
	public function filter_archive_recipe_card_classes( $classes_array ) {

//		if ( 'recipes_browse' != $this->shortcode_called ) {
//			return null;
//		}

		$recipe_archive_layout = $this->shortcode_atts['recipe_archive_layout'];

		switch ( $recipe_archive_layout ) {
			case( 'grid' ):
				$classes_array[] = 'grid-archive';
				break;

			case( 'list' ):
				$classes_array[] = 'list-archive';
				break;

			case( 'modern' ):
				$classes_array[] = 'modern-archive';
				break;

			case( 'overlay' ):
				$classes_array[] = 'overlay-archive';
				break;

			default:
		}

		if ( $this->get_options_value( 'show_in_masonry' ) === 'yes' ) {
			$classes_array[] = 'masonry-grid-item';
		}


		return $classes_array;


		return $classes_array;


	}

	/**
	 * @return string
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * @param $atts
	 */
	protected function set_shortcode_atts( $atts ) {
		$this->shortcode_atts = $atts;
	}

	/**
	 * @param $atts
	 */
	protected function add_shortcode_css_recipes_browse( $atts ) {

		$prefix_class = $this->get_prefix_class();

		add_filter( 'boorecipe_filter_archive_recipe_wrap_classes', array( $this, 'set_prefix_class' ) );

		$color_archive_title = isset( $atts['color_archive_title'] )
			? boorecipe_sanitize_color( $atts['color_archive_title'] )
			: $this->get_options_value( 'color_archive_title' );

		$color_archive_excerpt = isset( $atts['color_archive_excerpt'] )
			? boorecipe_sanitize_color( $atts['color_archive_excerpt'] )
			: $this->get_options_value( 'color_archive_excerpt' );

		$color_archive_keys = isset( $atts['color_archive_keys'] )
			? boorecipe_sanitize_color( $atts['color_archive_keys'] )
			: $this->get_options_value( 'color_archive_keys' );

		$color_card_bg = isset( $atts['color_card_bg'] )
			? boorecipe_sanitize_color( $atts['color_card_bg'] )
			: $this->get_options_value( 'color_card_bg' );

		$color_archive_hover_overlay = isset( $atts['color_archive_hover_overlay'] )
			? boorecipe_sanitize_color( $atts['color_archive_hover_overlay'] )
			: $this->get_options_value( 'color_archive_hover_overlay' );

		$color_archive_key_points_bg = isset( $atts['color_archive_key_points_bg'] )
			? boorecipe_sanitize_color( $atts['color_archive_key_points_bg'] )
			: $this->get_options_value( 'color_archive_key_points_bg' );

		$color_card_border = isset( $atts['color_card_border'] )
			? boorecipe_sanitize_color( $atts['color_card_border'] )
			: $this->get_options_value( 'color_card_border' );

		$card_border_radius_pixels = isset( $atts['card_border_radius_pixels'] )
			? absint( $atts['card_border_radius_pixels'] )
			: $this->get_options_value( 'card_border_radius_pixels' );

		$card_border_pixels = isset( $atts['card_border_pixels'] )
			? (int) ( $atts['card_border_pixels'] )
			: $this->get_options_value( 'card_border_pixels' );

		$card_content_alignment = isset( $atts['card_content_alignment'] )
			? sanitize_key( $atts['card_content_alignment'] )
			: $this->get_options_value( 'card_content_alignment' );

		$show_rounded_card_border = isset( $atts['show_rounded_card_border'] )
			? sanitize_key( $atts['show_rounded_card_border'] )
			: $this->get_options_value( 'show_rounded_card_border' );


		$css = '';
		$css .= ".$prefix_class .recipe-archive-title > * { color: {$color_archive_title};} ";
		$css .= ".$prefix_class .recipe-archive-author {color: {$color_archive_excerpt}; font-size: 0.8em;	margin-bottom: 1em;}";
		$css .= ".$prefix_class .recipe-card-content p {margin-bottom: 0.8em;	color: {$color_archive_excerpt};}";
		$css .= ".$prefix_class .recipe-keypoints {color: {$color_archive_keys};}";
		$css .= ".$prefix_class .recipe-keypoints svg {fill: {$color_archive_keys};}";
		$css .= ".$prefix_class .recipe-card a {background: {$color_card_bg};}";
		$css .= ".$prefix_class .modern-archive .recipe-card-content {	background-color: {$color_archive_hover_overlay};}";
		$css .= ".$prefix_class .recipe-card-content {	text-align: $card_content_alignment; }";
		$css .= ".$prefix_class .recipe-card:not(.overlay-archive) .recipe-keypoints {	background-color: {$color_archive_key_points_bg};}";
		$css .= ".overlay-container {background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, {$color_archive_hover_overlay} 90%,{$color_archive_hover_overlay} 97%)}";

		if ( $show_rounded_card_border === 'yes' ) {
			$css .= ".$prefix_class .recipe-card a { overflow: hidden; border-radius:{$card_border_radius_pixels}px; border: {$card_border_pixels}px solid {$color_card_border};}";
		}


		$css .= "";

		$this->add_shortcode_css( $css );
//		return $css;

	}

	/**
	 * @param $css
	 */
	protected function add_shortcode_css( $css ) {
		$this->shortcode_css = $this->shortcode_css . $css;
		wp_add_inline_style( $this->plugin_name . '-shortcodes', $css );
	}


}

