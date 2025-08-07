<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe' ) ) {
	return;
}

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Boorecipe
 * @subpackage Boorecipe/includes
 * @author     Rao Abid <raoabid491@gmail.com>
 */
class Boorecipe {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Boorecipe_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'BOORECIPE_VERSION' ) ) {
			$this->version = BOORECIPE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'boo-recipes';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();


		$this->define_custom_post_types_hooks();

		$this->define_ajax_recipe_meta_update();

		$this->define_shortcode_hooks();

		$this->define_single_template_hooks();

		$this->define_archive_template_hooks();

		$this->define_aside_template_hooks();

		$this->define_widget_template_hooks();

		$this->define_widget_hooks();

		$this->define_customization_hook();


	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Boorecipe_Loader. Orchestrates the hooks of the plugin.
	 * - Boorecipe_i18n. Defines internationalization functionality.
	 * - Boorecipe_Admin. Defines all hooks for the admin area.
	 * - Boorecipe_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {


		/**
		 * Composer Auto Loader
		 */

		require plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/autoload.php';

		new Boorecipe_Globals( $this->plugin_name, $this->version );

		/**
		 * Helper Functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/helper-functions.php';

		/**
		 * JSON-LD Schema Generator
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-boorecipe-jsonld-generator.php';

		/**
		 * Premium Custom Posts (Taxonomies)
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-boorecipe-premium-custom_posts.php';

		/**
		 * Premium Single Template Functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-boorecipe-premium-single-template-functions.php';

		/**
		 * Premium Archive Template Functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-boorecipe-premium-archive-template-functions.php';

		/**
		 * Premium Widget Template Functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-boorecipe-premium-widget-template-functions.php';

		/**
		 * Premium Admin Simple
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-boorecipe-premium-admin-simple.php';

		/**
		 * Premium Widgets
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-boorecipe-premium-widgets.php';

		/**
		 * Initialize custom template loader
		 *
		 * Template File Loaders in Plugins
		 * Template file loaders like this are used in a lot of large-scale plugins in order to
		 * provide greater flexibility and better control for advanced users that want to tailor
		 * a plugin's output more to their specific needs.
		 *
		 * @link https://github.com/pippinsplugins/pw-sample-template-loader-plugin
		 * @link https://pippinsplugins.com/template-file-loaders-plugins/
		 */

		$this->loader = new Boorecipe_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Boorecipe_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Boorecipe_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin_simple = new Boorecipe_Admin_Simple( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin_simple, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin_simple, 'enqueue_scripts' );
		/*
		 * Added the plugin options menu and page
		 */
		$this->loader->add_action( 'admin_menu', $plugin_admin_simple, 'admin_menu_simple', 99 );

		/*
		 * Added the plugin options menu and page
		 */
		$this->loader->add_action( 'widgets_init', $plugin_admin_simple, 'register_sidebar_widgets', 999 );

		// Premium Admin Simple
		$plugin_premium_admin_simple = new Boorecipe_Premium_Admin_Simple( $this->get_plugin_name(), $this->get_version() );

		// Add premium admin hooks
		$this->loader->add_filter( 'boorecipe_options_sections_array', $plugin_premium_admin_simple, 'filter_options_sections_array', 10 );
		$this->loader->add_filter( 'boorecipe_options_args_array', $plugin_premium_admin_simple, 'filter_options_fields_array', 10 );
		$this->loader->add_filter( 'boorecipe_options_args_array', $plugin_premium_admin_simple, 'filter_options_args_array_activation_tab_update', 20 );
		$this->loader->add_filter( 'boorecipe_options_args_array', $plugin_premium_admin_simple, 'filter_options_args_array_search_form', 30 );
		$this->loader->add_filter( 'boorecipe_options_args_array', $plugin_premium_admin_simple, 'filter_options_recipe_single', 40 );
		$this->loader->add_filter( 'boorecipe_options_args_array', $plugin_premium_admin_simple, 'filter_options_recipe_single_style', 50 );
		$this->loader->add_filter( 'boorecipe_options_args_array', $plugin_premium_admin_simple, 'filter_options_recipe_archive', 60 );
		$this->loader->add_filter( 'boorecipe_options_args_array', $plugin_premium_admin_simple, 'filter_options_uninstall_section', 70 );
		$this->loader->add_filter( 'boorecipe_options_args_array', $plugin_premium_admin_simple, 'filter_options_recipe_archive_layout', 80 );


		if ( boorecipe_is_old_settings_available() ) {

			$plugin_admin = new Boorecipe_Admin( $this->get_plugin_name(), $this->get_version() );

			$this->loader->add_action( 'admin_head', $plugin_admin, 'display_old_settings_admin_notice' );

			/*
			 * Added the plugin options menu and page
			 */
			$this->loader->add_action( 'init', $plugin_admin, 'create_plugin_menu', 999 );

		}
		/**
		 * Adding Ajax Functionality
		 */
		$this->loader->add_action( 'wp_ajax_admin_convert_settings', $plugin_admin_simple, 'admin_convert_settings_handler' );
		$this->loader->add_action( 'wp_ajax_admin_delete_settings', $plugin_admin_simple, 'admin_delete_settings_handler' );

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Boorecipe_Public( $this->get_plugin_name(), $this->get_version() );


		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );


		//OR
		$this->loader->add_filter( 'single_template', $plugin_public, 'single_recipe_template' );
		$this->loader->add_filter( 'archive_template', $plugin_public, 'archive_recipe_template' );

		$this->loader->add_action( 'pre_get_posts', $plugin_public, 'alter_query_to_add_recipe_posttype' );

		/**
		 * JSON-LD Schema Generator
		 */
		$jsonld_generator = new Boorecipe_JSONLD_Generator( $this );
		$this->loader->add_action( 'wp_head', $jsonld_generator, 'output_schema' );

	} // define_public_hooks()

	/**
	 * Register all of the hooks related to the custom post types functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_custom_post_types_hooks() {


		/*
		 * Creating Custom Post types
		 */
		$plugin_post_types = new Boorecipe_Post_Types();

		$this->loader->add_filter( 'rwmb_meta_boxes', $plugin_post_types, 'register_meta_box_primary' );
		$this->loader->add_filter( 'rwmb_meta_boxes', $plugin_post_types, 'register_meta_box_nutrition', 12 );


		$this->loader->add_action( 'init', $plugin_post_types, 'create_custom_post_type', 999 );

		$this->loader->add_action( 'save_post', $plugin_post_types, 'update_contents_of_post_with_title', 999, 3 );

		/*
		 * Premium Custom Post Types (Taxonomies)
		 */
		$plugin_premium_post_types = new Boorecipe_Premium_Post_Types();

		$this->loader->add_filter( 'rwmb_meta_boxes', $plugin_premium_post_types, 'register_meta_box_premium', 13 );

		$this->loader->add_action( 'init', $plugin_premium_post_types, 'create_custom_post_type', 1000 );

		// Register premium taxonomies
		$this->loader->add_filter( 'boorecipe_taxonomies_create_args', $plugin_premium_post_types, 'filter_taxonomies_create_args', 10, 1 );


	} // define_custom_post_types_hooks()

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_ajax_recipe_meta_update() {

		if ( boorecipe_is_old_settings_available() ) {

			$ajax_meta = new Boorecipe_Admin_Ajax_Meta_Update( $this->get_plugin_name(), $this->get_version() );

			$this->loader->add_action( 'admin_enqueue_scripts', $ajax_meta, 'ajax_admin_enqueue_scripts', 10 );
			$this->loader->add_action( 'wp_ajax_update_recipe_meta', $ajax_meta, 'ajax_admin_handler', 10 );
		}


	} //define_ajax_recipe_meta_update

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_shortcode_hooks() {
		// Adding New Shortcodes
		$plugin_shortcode = new Boorecipe_Shortcodes( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_shortcode, 'register_styles' );

		$this->loader->add_shortcode( "boorecipe_search_form", $plugin_shortcode, "boorecipe_search_form" );

		$this->loader->add_shortcode( "boorecipe_print_button", $plugin_shortcode, "boorecipe_print_button" );

		$this->loader->add_shortcode( "recipes_browse", $plugin_shortcode, "recipes_browse" );
		$this->loader->add_shortcode( "recipe_embed", $plugin_shortcode, "recipe_embed" );

	} //define_shortcode_hooks


	/**
	 * Register all of the hooks related to single template functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_single_template_hooks() {

		$single_template = new Boorecipe_Single_Template_Functions( $this->get_plugin_name(), $this->get_version() );

		// Premium single template functions
		$single_premium_templates = new Boorecipe_Premium_Single_Template_Functions( $this->get_plugin_name(), $this->get_version() );

		// Filter for Single Recipe
		$this->loader->add_filter( 'boorecipe_single_recipe_wrapper_classes', $single_template, 'filter_recipe_wrapper_classes', 10, 1 );
		$this->loader->add_filter( 'boorecipe_single_recipe_post_classes', $single_template, 'filter_recipe_post_classes', 10, 1 );

		/*
		 * Single Recipe Media
		 */
		$this->loader->add_action( 'boorecipe_single_media', $single_template, 'recipe_featured_image', 10, 2 );

		// Premium Media Features
		$this->loader->add_action( 'boorecipe_single_media', $single_premium_templates, 'recipe_image_slider', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_media', $single_premium_templates, 'recipe_video_section', 10, 2 );

		/*
		 * Single Recipe Head
		 */
		$this->loader->add_action( 'boorecipe_single_head', $single_template, 'the_title', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_head', $single_template, 'sub_section_publish_info', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_head', $single_template, 'sub_section_short_description', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_head_publish_info', $single_template, 'the_author', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_head_publish_info', $single_template, 'the_date', 10, 2 );

		/*
		 * Single Recipe Meta
		 */

		/*
		 * Single Recipe Body
		 */
		$this->loader->add_action( 'boorecipe_single_body', $single_template, 'ingredients', 9, 2 );
		$this->loader->add_action( 'boorecipe_single_body', $single_template, 'instructions', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_body', $single_template, 'additional_notes', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_body', $single_template, 'nutrition', 11, 2 );

		// Premium Body Features
		$this->loader->add_action( 'boorecipe_single_body', $single_premium_templates, 'recipe_tool_display', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_body', $single_premium_templates, 'cooking_methods_display', 10, 2 );

		// Premium After Body Features
		$this->loader->add_action( 'boorecipe_single_body_after', $single_premium_templates, 'ratings_display', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_body_after', $single_premium_templates, 'author_box', 11, 2 );
		$this->loader->add_action( 'boorecipe_single_body_after', $single_premium_templates, 'related_recipes_section', 13, 2 );

		// Recipe Taxonomies
		$this->loader->add_action( 'boorecipe_single_meta', $single_template, 'sub_section_meta_taxonomy_style_1', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_taxonomy', $single_template, 'the_taxonomy_icon', 8, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_taxonomy', $single_template, 'the_taxonomy_category', 9, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_taxonomy', $single_template, 'the_taxonomy_tags', 11, 2 );

		// Premium Taxonomy
		$this->loader->add_action( 'boorecipe_single_meta_taxonomy', $single_premium_templates, 'the_taxonomy_cuisine', 10, 2 );

		// Recipe Times
		$this->loader->add_action( 'boorecipe_single_meta', $single_template, 'sub_section_meta_time_style_1', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_time_style_1', $single_template, 'the_time_icon', 8, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_time_style_1', $single_template, 'recipe_prep_time', 9, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_time_style_1', $single_template, 'recipe_cook_time', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_time_style_1', $single_template, 'recipe_total_time', 11, 2 );

		// Recipe Key Points
		$this->loader->add_action( 'boorecipe_single_meta', $single_template, 'sub_section_meta_key_point_style_1', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_key_point_style_1', $single_template, 'the_key_point_icon', 8, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_key_point_style_1', $single_template, 'yields', 9, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_key_point_style_1', $single_template, 'the_taxonomy_skill_level', 9, 2 );

		// Premium Key Points
		$this->loader->add_action( 'boorecipe_single_meta_key_point_style_1', $single_premium_templates, 'the_taxonomy_cooking_method', 15, 2 );

		/*
		 * Recipe Style : 2
		 */
		$this->loader->add_action( 'boorecipe_single_meta', $single_premium_templates, 'sub_section_meta_key_point_style_2', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_key_point_style_2', $single_premium_templates, 'the_taxonomy_category_style_2', 15, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_key_point_style_2', $single_premium_templates, 'the_taxonomy_cuisine_style_2', 15, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_key_point_style_2', $single_premium_templates, 'the_taxonomy_tags_style_2', 15, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_key_point_style_2', $single_premium_templates, 'the_taxonomy_skill_level_style_2', 15, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_key_point_style_2', $single_premium_templates, 'the_taxonomy_cooking_method_style_2', 15, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_key_point_style_2', $single_premium_templates, 'key_point_yields_style_2', 15, 2 );

		$this->loader->add_action( 'boorecipe_single_body_before', $single_premium_templates, 'section_sharing_buttons_style_2', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_body_before', $single_premium_templates, 'sub_section_meta_time_style_2', 9, 2 );

		$this->loader->add_action( 'boorecipe_single_meta_time_style_2', $single_premium_templates, 'the_time_icon', 8, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_time_style_2', $single_premium_templates, 'recipe_prep_time', 9, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_time_style_2', $single_premium_templates, 'recipe_cook_time', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_time_style_2', $single_premium_templates, 'recipe_total_time', 11, 2 );

		/*
		 * Recipe Style : 3
		 */
		$this->loader->add_filter( 'boorecipe_single_recipe_layout_class', $single_premium_templates, 'single_recipe_layout_class' );
		$this->loader->add_action( 'boorecipe_single_body_before', $single_premium_templates, 'add_boo_recipe_details_wrapper', 5 );
		$this->loader->add_action( 'boorecipe_single_body_after', $single_premium_templates, 'close_boo_recipe_details_wrapper', 15 );

		// Style 3 specific elements (same as other styles but with different visual presentation)
		$this->loader->add_action( 'boorecipe_single_head_after', $single_template, 'section_sharing_buttons_style_1', 10, 2 );

		// Premium Filters
		$this->loader->add_filter( 'boorecipe_before_showing_featured_image', $single_premium_templates, 'is_recipe_have_video_or_image', 10, 2 );

		// Advanced Template Hooks (only for methods that exist)
		$this->loader->add_action( 'boorecipe_single_media_before', $single_premium_templates, 'single_media_before', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_media_after', $single_premium_templates, 'single_media_after', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_head_before', $single_premium_templates, 'single_head_before', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_head_after', $single_premium_templates, 'single_head_after', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_before', $single_premium_templates, 'single_meta_before', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_after', $single_premium_templates, 'single_meta_after', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_body_before', $single_premium_templates, 'single_body_before', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_body_after', $single_premium_templates, 'single_body_after', 10, 2 );

		/*
		 * Single Recipe Wrapper Classes
		 */
		$this->loader->add_filter( 'boorecipe_single_recipe_wrapper_classes', $single_template, 'add_single_recipe_style_class' );

		/*
		 * Body Class
		 */
		$this->loader->add_filter( 'body_class', $single_template, 'add_recipe_style_class' );

	} // define_single_template_hooks()

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_archive_template_hooks() {

		$plugin_archive_template = new Boorecipe_Archive_Template_Functions( $this->get_plugin_name(), $this->get_version() );
		// Loop Archive Pages
		$this->loader->add_action( 'boorecipe_archive_wrap_start', $plugin_archive_template, 'archive_wrap_start' );
		$this->loader->add_action( 'boorecipe_archive_wrap_end', $plugin_archive_template, 'archive_wrap_end' );
		$this->loader->add_filter( 'boorecipe_set_archive_layout', $plugin_archive_template, 'filter_set_layout' );


		$this->loader->add_action( 'boorecipe_archive_no_result', $plugin_archive_template, 'archive_no_result' );
		$this->loader->add_action( 'boorecipe_archive_wrap_start_inside', $plugin_archive_template, 'insert_layout_switcher' );
		$this->loader->add_action( 'boorecipe_archive_wrap_start_inside', $plugin_archive_template, 'insert_search_form', 11 );
//		$this->loader->add_action( 'boorecipe_archive_wrap_end_inside', $plugin_archive_template, 'insert_search_form_at_end', 11 );
		$this->loader->add_action( 'boorecipe_archive_wrap_end_inside', $plugin_archive_template, 'archive_pagination_links', 10 );


		// Archive Recipes
		$this->loader->add_action( 'boorecipe_archive_recipe_media', $plugin_archive_template, 'archive_recipe_media_featured_image', 10, 1 );
		$this->loader->add_action( 'boorecipe_archive_recipe_content', $plugin_archive_template, 'archive_recipe_title', 8, 2 );

		$this->loader->add_action( 'boorecipe_archive_recipe_content', $plugin_archive_template, 'archive_recipe_excerpt', 10, 2 );

		$this->loader->add_action( 'boorecipe_archive_recipe_key_points', $plugin_archive_template, 'archive_recipe_key_points_yields', 10, 2 );

		$this->loader->add_action( 'boorecipe_archive_recipe_key_points', $plugin_archive_template, 'archive_recipe_key_points_skill_level', 10, 2 );


		$this->loader->add_filter( 'boorecipe_archive_title_args', $plugin_archive_template, 'filter_archive_title_args', 10, 2 );

		$this->loader->add_filter( 'boorecipe_filter_archive_recipe_wrap_classes', $plugin_archive_template, 'filter_archive_recipe_wrap_classes' );

		$this->loader->add_filter( 'boorecipe_filter_archive_recipe_card_classes', $plugin_archive_template, 'filter_archive_recipe_card_classes' );

		$this->loader->add_filter( 'boorecipe_filter_archive_image_size', $plugin_archive_template, 'filter_archive_image_size', 10, 1 );

		// Premium Archive Template Functions
		$plugin_premium_archive_template = new Boorecipe_Premium_Archive_Template_Functions( $this->get_plugin_name(), $this->get_version() );

		// Premium Archive Actions
		$this->loader->add_action( 'boorecipe_archive_recipe_key_points', $plugin_premium_archive_template, 'archive_recipe_key_points_total_time', 10, 2 );
		$this->loader->add_action( 'boorecipe_archive_recipe_content', $plugin_premium_archive_template, 'archive_recipe_author_name', 8, 2 );

		// Premium Archive Filters
		$this->loader->add_filter( 'boorecipe_filter_archive_recipe_card_classes', $plugin_premium_archive_template, 'filter_archive_recipe_card_classes', 20 );
		$this->loader->add_filter( 'boorecipe_filter_archive_recipe_wrap_classes', $plugin_premium_archive_template, 'filter_archive_recipe_wrap_classes', 20 );
	}

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_aside_template_hooks() {

		$plugin_aside_template = new Boorecipe_Aside_Template_Functions( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'boorecipe_recipe_single_aside', $plugin_aside_template, 'aside_recipe_single', 10, 2 );
		$this->loader->add_filter( 'boorecipe_aside_single_recipe_classes', $plugin_aside_template, 'filter_aside_single_recipe_classes', 10, 1 );
	}

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_widget_template_hooks() {

		$widget_template = new Boorecipe_Widget_Template_Functions( $this->get_plugin_name(), $this->get_version() );

		//Search Form Fields
		$this->loader->add_action( 'boorecipe_widget_search_form_fields', $widget_template, 'search_form_category_field', 7 );
		$this->loader->add_action( 'boorecipe_widget_search_form_fields', $widget_template, 'search_form_skill_level_field', 9 );
		$this->loader->add_action( 'boorecipe_widget_search_form_fields', $widget_template, 'search_form_keyword_field', 9 );

		// Premium Widget Template Functions
		$premium_widget_template = new Boorecipe_Premium_Widget_Template_Functions( $this->get_plugin_name(), $this->get_version() );

		// Premium Search Form Fields
		$this->loader->add_action( 'boorecipe_widget_search_form_fields', $premium_widget_template, 'search_form_cuisine_field', 8 );
	}

	/**
	 * Register all of the hooks related to widgets
	 * of the plugin.
	 *
	 * @plugin   boorecipe
	 * @since    1.0
	 * @access   private
	 */
	private function define_widget_hooks() {

		$plugin_widgets = new Boorecipe_Widgets( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'widgets_init', $plugin_widgets, 'widgets_init' );

		// Premium Widgets
		$plugin_premium_widgets = new Boorecipe_Premium_Widgets( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'widgets_init', $plugin_premium_widgets, 'widgets_init' );


	}


	/**
	 * Register all of the hooks related to widgets
	 * of the plugin.
	 *
	 * @plugin   boorecipe
	 * @since    1.0
	 * @access   private
	 */
	private function define_customization_hook() {


		$plugin_customization = new Boorecipe_Customization( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_head', $plugin_customization, 'recipe_single_configurable_styles' );

		$this->loader->add_action( 'wp_head', $plugin_customization, 'recipe_archive_configurable_styles' );

		$this->loader->add_action( 'wp_head', $plugin_customization, 'recipe_global_configurable_styles' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Boorecipe_Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * @param $option_id
	 *
	 * @return bool|mixed
	 */
	public function get_options_value( $option_id ) {
		return Boorecipe_Globals::get_options_value( $option_id );
	}

}
