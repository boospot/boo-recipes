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

				$search_keyword = isset( $_GET['keyword'] ) ? sanitize_text_field( $_GET['keyword'] ) : false;

				if ( $search_keyword ) {

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
						$custom_meta[] = array(
							'key'     => $meta_key,
							'value'   => $search_keyword,
							'compare' => 'LIKE'
						);
					}


//					foreach ( $meta_fields as $meta_key ) {
//						$custom_meta[] = array(
//							'key'     => $meta_key,
//							'value'   => $search_keyword,
//							'compare' => 'LIKE'
//						);
//					}


					$meta_query = $current_meta = $custom_meta;

					$query->set( 'meta_query', array( $meta_query ) );
				}

			}

		}

	}

	public function is_search_form_submitted() {

		$is_search_form_submitted = (
			isset( $_GET['recipe_search'] )
			&& ! empty( ( sanitize_key( $_GET['recipe_search'] ) ) )
		)
			? true : false;

		return $is_search_form_submitted;

	}

}
