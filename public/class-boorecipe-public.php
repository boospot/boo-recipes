<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Public' ) ) {
	return;
}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Boorecipe
 * @subpackage Boorecipe/public
 * @author     Rao Abid <raoabid491@gmail.com>
 */
class Boorecipe_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The ID of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of this plugin.
	 */
	protected $version;


	/**
	 * The plugin options
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array $options The plugin options
	 */
	protected $options;


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

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->set_options();
	}


	protected function set_options() {
		$this->options = Boorecipe_Globals::get_options();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Boorecipe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Boorecipe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_style( $this->plugin_name . "-single", plugin_dir_url( __FILE__ ) . 'css/boorecipe-single.css', array(), $this->version, 'all' );


		wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/style.css', array(), $this->version, 'all' );


		// Required for Search Widget
		// 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css'
		wp_register_style( 'select2', plugin_dir_url( __FILE__ ) . 'css/lib/select2.min.css', array(), '4.0.6', 'all' );


		// Loaded Everywhere
		wp_enqueue_style( $this->plugin_name );

		wp_enqueue_style( 'select2' );

		if ( is_singular( 'boo_recipe' ) || boorecipe_is_active_shortcode_single() ) {
			wp_enqueue_style( $this->plugin_name . "-single" );
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Boorecipe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Boorecipe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script( 'jquery-select2', plugin_dir_url( __FILE__ ) . 'js/lib/select2.min.js', array( 'jquery' ), '4.0.6', false );

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/boorecipe-public.js', array( 'jquery' ), $this->version, false );


		/*
		 * Enqueue Scripts
		 */

		wp_enqueue_script( 'jquery-select2' );

		if ( $this->get_options_value( 'show_in_masonry' ) === 'yes' ) {
			wp_enqueue_script( 'masonry' );
		}

		wp_enqueue_script( $this->plugin_name );


	}

	public function get_options_value( $option_id ) {
		return Boorecipe_Globals::get_options_value( $option_id );
	}

	/**
	 * Adds a default single view template for a job opening
	 *
	 * @param string $template The name of the template
	 *
	 * @return    mixed                        The single template
	 */
	public function single_recipe_template( $template ) {

		global $post;

		if ( $post->post_type == 'boo_recipe' ) {

			$template = boorecipe_get_template( 'single-recipe' );

		}

		return $template;

	}

	public function archive_recipe_template( $archive_template ) {

		if ( $this->is_recipe_taxonomy_archive() || is_post_type_archive( 'boo_recipe' ) ) {

			$archive_template = boorecipe_get_template( 'archive-recipe' );

		}

		return $archive_template;
	} // single_recipe_template()

	public function is_recipe_taxonomy_archive() {
		if ( is_archive() && boorecipe_is_recipe_taxonomy() ) {
			return true;
		} else {
			return false;
		}

	}

	public function alter_query_to_add_recipe_posttype( \WP_Query $query ) {

		if ( is_admin() ) {
			return $query;
		}

		if ( $query->is_main_query() &&
		     ( is_post_type_archive( 'boo_recipe' ) || boorecipe_is_recipe_taxonomy() )
		) {

			// Update Query for custom post type
			$query->set( 'post_type', 'boo_recipe' );


			// Set Recipes Per Page
			$recipes_per_page = ( absint( $this->get_options_value( 'recipes_per_page' ) ) > 0 ) ? absint( $this->get_options_value( 'recipes_per_page' ) ) : 9;


			$query->set( 'posts_per_page', $recipes_per_page );


			// Add Keyword Search to the Query
			if ( $this->is_search_form_submitted() ) {

				$search_keyword = '';
				if ( isset( $_GET['keyword'] ) && is_string( $_GET['keyword'] ) ) {
					$search_keyword = sanitize_text_field( $_GET['keyword'] );
				}

				if ( ! empty( $search_keyword ) ) {

					$custom_meta = array();

					$current_meta = $query->get( 'meta_query' );


					$meta_fields_to_include_in_search = apply_filters( 'boorecipe_filter_search_meta_fields', array(
						'boorecipe_recipe_title',
						'boorecipe_directions',
						'boorecipe_ingredient',
						'boorecipe_short_description'
					) );


					$custom_meta['relation'] = 'OR';

					foreach ( $meta_fields_to_include_in_search as $meta_key ) {
						if ( is_string( $meta_key ) ) {
							$custom_meta[] = array(
								'key'     => sanitize_key( $meta_key ),
								'value'   => $search_keyword,
								'compare' => 'LIKE'
							);
						}
					}


//					foreach ( $meta_fields as $meta_key ) {
//						$custom_meta[] = array(
//							'key'     => $meta_key,
//							'value'   => $search_keyword,
//							'compare' => 'LIKE'
//						);
//					)


					$meta_query = $current_meta = $custom_meta;

					$query->set( 'meta_query', array( $meta_query ) );
				}

			}

		}

	}

	public function is_search_form_submitted() {

		$is_search_form_submitted = false;
		
		if ( isset( $_GET['recipe_search'] ) && is_string( $_GET['recipe_search'] ) ) {
			$recipe_search = sanitize_key( $_GET['recipe_search'] );
			$is_search_form_submitted = ! empty( $recipe_search );
		}

		return $is_search_form_submitted;

	}

	/**
	 * Disable WordPress auto-paragraphing for recipe content
	 * This prevents empty <p></p> tags from being added
	 *
	 * @param string $content The post content
	 * @return string The modified content
	 */
    public function disable_wpautop_for_recipes( $content ) {

        // Apply to single recipes, recipe archives/taxonomies, and when recipe shortcodes are active (embed)
        if (
            is_singular( 'boo_recipe' )
            || is_post_type_archive( 'boo_recipe' )
            || boorecipe_is_recipe_taxonomy()
            || boorecipe_is_active_shortcode_single()
        ) {
			// Remove wpautop filter temporarily
			remove_filter( 'the_content', 'wpautop' );
			remove_filter( 'the_excerpt', 'wpautop' );
			remove_filter( 'widget_text_content', 'wpautop' );
			
			// Also remove other content filters that might add empty tags
			remove_filter( 'the_content', 'wptexturize' );
			remove_filter( 'the_excerpt', 'wptexturize' );
			remove_filter( 'widget_text_content', 'wptexturize' );
		}
		
		return $content;
	}

	/**
	 * Start output buffering for recipe templates to prevent whitespace issues
	 */
    public function start_output_buffering_for_recipes() {

        // Apply to single recipes, archives/taxonomies, and recipe shortcodes (embed)
        if (
            is_singular( 'boo_recipe' )
            || is_post_type_archive( 'boo_recipe' )
            || boorecipe_is_recipe_taxonomy()
            || boorecipe_is_active_shortcode_single()
        ) {
			ob_start( array( $this, 'clean_output_buffer' ) );
		}
	}

	/**
	 * End output buffering for recipe templates
	 */
    public function end_output_buffering_for_recipes() {

        // Apply to single recipes, archives/taxonomies, and recipe shortcodes (embed)
        if (
            is_singular( 'boo_recipe' )
            || is_post_type_archive( 'boo_recipe' )
            || boorecipe_is_recipe_taxonomy()
            || boorecipe_is_active_shortcode_single()
        ) {
			if ( ob_get_level() ) {
				ob_end_flush();
			}
		}
	}

	/**
	 * Clean the output buffer to remove empty p tags and extra whitespace
	 *
	 * @param string $buffer The output buffer content
	 * @return string The cleaned content
	 */
    public function clean_output_buffer( $buffer ) {

        // Remove empty paragraph wrappers introduced by autop or editors
        // 1) Purely empty <p></p>
        $buffer = preg_replace( '/<p>\s*<\/p>/i', '', $buffer );
        // 2) <p><br/></p> or any number of <br> and whitespace inside
        $buffer = preg_replace( '/<p>\s*(?:<br\s*\/??>\s*)+<\/p>/i', '', $buffer );
        // 3) <p>&nbsp;</p>
        $buffer = preg_replace( '/<p>\s*&nbsp;\s*<\/p>/i', '', $buffer );
        // 4) <p><!-- comment --></p>
        $buffer = preg_replace( '/<p>\s*<!--.*?-->\s*<\/p>/is', '', $buffer );

        // Keep overall whitespace intact to avoid layout side-effects
        // Only trim whitespace between tags conservatively (single space)
        $buffer = preg_replace( '/>\s+</', '><', $buffer );

        return $buffer;
    }

	/**
	 * Disable Elementor wpautop for recipe content
	 *
	 * @param array $data Elementor content data
	 * @param int $post_id Post ID
	 * @return array Modified data
	 */
    public function disable_elementor_wpautop_for_recipes( $data, $post_id ) {

        // Check if this is a recipe post or an active recipe shortcode context
        if ( get_post_type( $post_id ) === 'boo_recipe' || boorecipe_is_active_shortcode_single() ) {
			// Remove wpautop from Elementor's content processing
			remove_filter( 'the_content', 'wpautop' );
			remove_filter( 'the_excerpt', 'wpautop' );
		}
		
		return $data;
	}

	/**
	 * Clean Elementor widget content to remove empty p tags
	 *
	 * @param string $content Widget content
	 * @param \Elementor\Widget_Base $widget Widget instance
	 * @return string Cleaned content
	 */
    public function clean_elementor_widget_content( $content, $widget ) {

        // Only apply to text editor widgets that contain recipe content or embeds
        if (
            $widget->get_name() === 'text-editor'
            && (
                is_singular( 'boo_recipe' )
                || is_post_type_archive( 'boo_recipe' )
                || boorecipe_is_recipe_taxonomy()
                || boorecipe_is_active_shortcode_single()
            )
        ) {
            // Remove empty p tags and autop artefacts
            $content = preg_replace( '/<p>\s*<\/p>/i', '', $content );
            $content = preg_replace( '/<p>\s*(?:<br\s*\/??>\s*)+<\/p>/i', '', $content );
            $content = preg_replace( '/<p>\s*&nbsp;\s*<\/p>/i', '', $content );
            $content = preg_replace( '/<p>\s*<!--.*?-->\s*<\/p>/is', '', $content );
            $content = preg_replace( '/>\s+</', '><', $content );
        }

        return $content;
    }

	/**
	 * Clean Elementor content to remove empty p tags
	 *
	 * @param string $content Elementor content
	 * @return string Cleaned content
	 */
    public function clean_elementor_content( $content ) {

        // Apply to recipe post types and recipe embed shortcode contexts
        if (
            is_singular( 'boo_recipe' )
            || is_post_type_archive( 'boo_recipe' )
            || boorecipe_is_recipe_taxonomy()
            || boorecipe_is_active_shortcode_single()
        ) {
            // Remove empty p tags and autop artefacts
            $content = preg_replace( '/<p>\s*<\/p>/i', '', $content );
            $content = preg_replace( '/<p>\s*(?:<br\s*\/??>\s*)+<\/p>/i', '', $content );
            $content = preg_replace( '/<p>\s*&nbsp;\s*<\/p>/i', '', $content );
            $content = preg_replace( '/>\s+</', '><', $content );
            // Remove HTML comments that might be wrapped in p tags
            $content = preg_replace( '/<p>\s*<!--.*?-->\s*<\/p>/is', '', $content );
        }

        return $content;
    }

}
