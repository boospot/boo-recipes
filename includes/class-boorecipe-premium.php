<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// if class already defined, bail out
if ( class_exists( 'Boorecipe_Premium' ) ) {
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
 * @package    Boorecipe_Premium
 * @subpackage Boorecipe_Premium/includes
 * @author     Rao Abid <raoabid491@gmail.com>
 */
class Boorecipe_Premium {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Boorecipe_Premium_Loader $loader Maintains and registers all hooks for the plugin.
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
	 * The unique identifier of the parent plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $parent_plugin The string used to uniquely identify parent plugin.
	 */
	protected $parent_plugin;

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
			$this->version = '3.0.0';
		}

		$this->plugin_name = 'boo-recipes-premium';

		$this->parent_plugin = 'boorecipe';

		// For unified plugin, we don't need separate parent plugin paths
		// These are kept for compatibility but point to same plugin
		define( 'BOORECIPE_PREMIUM_PARENT_PLUGIN_URL', BOORECIPE_PLUGIN_URL );
		define( 'BOORECIPE_PREMIUM_PARENT_BASE_DIR', BOORECIPE_BASE_DIR );

		$this->load_dependencies();

		$this->set_locale();

		$this->define_global_hooks();

		// Skip auto updater for unified plugin
		// $this->load_auto_updater();

		$this->define_admin_hooks();

		$this->define_custom_post_types_hooks();

		$this->define_shortcode_hooks();

		$this->define_public_hooks();

		$this->define_template_hooks();

		$this->define_single_template_hooks();

		$this->define_archive_template_hooks();

		$this->define_aside_template_hooks();

		$this->define_widget_template_hooks();

		$this->define_widget_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Boorecipe_Premium_Loader. Orchestrates the hooks of the plugin.
	 * - Boorecipe_Premium_i18n. Defines internationalization functionality.
	 * - Boorecipe_Premium_Admin. Defines all hooks for the admin area.
	 * - Boorecipe_Premium_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {


		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		//		require_once BOORECIPE_PREMIUM_PARENT_BASE_DIR . 'includes/helper-functions.php';


		/**
		 * Composer Auto Loader - Skip for unified plugin, already loaded
		 */
		// require plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/autoload.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-boorecipe-premium-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-boorecipe-premium-i18n.php';


		/**
		 * The class responsible for all global functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-boorecipe-premium-global-functions.php';


		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-boorecipe-premium-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-boorecipe-premium-admin-simple.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-boorecipe-premium-public.php';

		$this->loader = new Boorecipe_Premium_Loader();


		/**
		 * The class responsible for defining all actions creating the templates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-boorecipe-premium-template-functions.php';


		/**
		 * The class responsible for defining all actions creating the single templates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-boorecipe-premium-single-template-functions.php';


		/**
		 * The class responsible for defining all actions creating the archive templates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-boorecipe-premium-archive-template-functions.php';

		/**
		 * The class responsible for defining all actions creating the widget templates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-boorecipe-premium-widget-template-functions.php';

		/*
		 * Require Post Type related Class
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-boorecipe-premium-custom_posts.php';


		/**
		 * Plugin Shortcodes
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-boorecipe-premium-shortcodes.php';

		/**
		 * Plugin Widgets
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-boorecipe-premium-widgets.php';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Boorecipe_Premium_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Boorecipe_Premium_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Used to Update
	 *
	 * Uses the Boorecipe_Premium_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_global_hooks() {
		$global_premium = new Boorecipe_Premium_Globals( $this->get_parent_plugin_name(), $this->version );

		$this->loader->add_filter( 'boorecipe_filter_default_labels_array', $global_premium, 'filter_default_labels_array', 8, 1 );

		$this->loader->add_filter( 'boorecipe_filter_default_options_array', $global_premium, 'filter_default_options_array', 8, 1 );
	}

	public function get_parent_plugin_name() {
		return $this->parent_plugin;
	}

	/**
	 * Load the required class for enabling auto updates
	 * DISABLED for unified plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_auto_updater() {
		// Disabled for unified plugin - no license checking needed
		return;
	}

	public function get_options_value( $option_id ) {
		return Boorecipe_Premium_Globals::get_options_value( $option_id );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		if ( $this->is_old_settings_available() ):
			$admin_premium = new Boorecipe_Premium_Admin( $this->get_parent_plugin_name(), $this->get_version() );

			$this->loader->add_filter( 'boorecipe_options_args_array', $admin_premium, 'filter_options_args_array_add_actions', 10, 1 );

			$this->loader->add_filter( 'boorecipe_options_args_array', $admin_premium, 'filter_options_args_array_activation_tab_update', 10, 1 );

			$this->loader->add_filter( 'recipe_options_search_form_section_fields_array', $admin_premium, 'filter_options_args_array_search_form', 10, 1 );


			// Recipe Archive Options Filtering
			$this->loader->add_filter( 'boorecipe_filter_options_recipe_archive', $admin_premium, 'filter_options_recipe_archive', 10, 1 );

			$this->loader->add_filter( 'boorecipe_filter_options_recipe_single', $admin_premium, 'filter_options_recipe_single', 10, 1 );

			$this->loader->add_filter( 'boorecipe_filter_options_recipe_single_style', $admin_premium, 'filter_options_recipe_single_style', 10, 1 );

			$this->loader->add_filter( 'boorecipe_filter_options_recipe_archive_layout', $admin_premium, 'filter_options_recipe_archive_layout', 10, 1 );

			$this->loader->add_filter( 'boorecipe_filter_options_recipe_archive_layout', $admin_premium, 'filter_options_recipe_archive_layout', 10, 1 );

			$this->loader->add_filter( 'boorecipe_filter_options_uninstall_section', $admin_premium, 'filter_options_uninstall_section', 10, 1 );

		endif;

		if ( class_exists( 'Boorecipe_Premium_Admin_Simple' ) ):

			$admin_premium_simple = new Boorecipe_Premium_Admin_Simple( $this->get_parent_plugin_name(), $this->get_version() );

			$this->loader->add_filter( 'boorecipe_filter_options_sections_array', $admin_premium_simple, 'filter_options_sections_array', 10, 1 );

			$this->loader->add_filter( 'boorecipe_filter_options_fields_array', $admin_premium_simple, 'filter_options_fields_array', 10, 1 );

			$this->loader->add_filter( 'boorecipe_filter_options_fields_array_activation', $admin_premium_simple, 'filter_options_args_array_activation_tab_update', 10, 1 );

			$this->loader->add_filter( 'boorecipe_filter_options_fields_array_search', $admin_premium_simple, 'filter_options_args_array_search_form', 10, 1 );

			// Recipe Archive Options Filtering
			$this->loader->add_filter( 'boorecipe_filter_options_fields_array_archive', $admin_premium_simple, 'filter_options_recipe_archive', 10, 1 );

			$this->loader->add_filter( 'boorecipe_filter_options_fields_array_single', $admin_premium_simple, 'filter_options_recipe_single', 10, 1 );

			$this->loader->add_filter( 'boorecipe_filter_options_fields_array_single_style', $admin_premium_simple, 'filter_options_recipe_single_style', 10, 1 );

			$this->loader->add_filter( 'boorecipe_filter_options_fields_array_archive_layout', $admin_premium_simple, 'filter_options_recipe_archive_layout', 10, 1 );

			$this->loader->add_filter( 'boorecipe_filter_options_recipe_archive_layout', $admin_premium_simple, 'filter_options_recipe_archive_layout', 10, 1 );

			$this->loader->add_filter( 'boorecipe_filter_options_fields_array_uninstall', $admin_premium_simple, 'filter_options_uninstall_section', 10, 1 );
		endif;
	}

	/**
	 *
	 */
	public function is_old_settings_available() {

		// Get old options
		$old_settings = get_option( 'boorecipe-options' );

		// if no old settings found, send error
		if ( $old_settings ) {
			return true;
		} else {
			return false;
		}
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
	 * Register all of the hooks related to the custom post types functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_custom_post_types_hooks() {
		$boorecipe_premium_post_types = new Boorecipe_Premium_Post_Types();


		/*
		 * For adding Additional Media Metabox
		 */
		$this->loader->add_filter( 'rwmb_meta_boxes', $boorecipe_premium_post_types, 'register_meta_box_premium', 11 );

		/*
		 * For adding Term Meta
		 */
		$this->loader->add_filter( 'rwmb_meta_boxes', $boorecipe_premium_post_types, 'register_meta_taxonomy_terms', 11 );

		/*
		 * For adding more Fields to Meta
		 */


		$this->loader->add_filter( 'boorecipe_recipe_metabox_fields', $boorecipe_premium_post_types, 'filter_metabox_fields_ingredients_switch' );


		/*
		 * For adding additional Taxonomies
		 */
		$this->loader->add_filter( 'boorecipe_taxonomies_create_args', $boorecipe_premium_post_types, 'filter_taxonomies_create_args' );

		/*
		 * Adding Ratings and Reviews to Comments
		 */


		$this->loader->add_action( 'comment_form_logged_in_after', $boorecipe_premium_post_types, 'ratings_fields_on_comments', 999 );
		$this->loader->add_action( 'comment_form_after_fields', $boorecipe_premium_post_types, 'ratings_fields_on_comments', 999 );

		// Save the comment meta data along with comment
		$this->loader->add_action( 'comment_post', $boorecipe_premium_post_types, 'save_ratings_on_comments_save', 999 );

		// Add the filter to check whether the comment meta data has been filled
		$this->loader->add_action( 'preprocess_comment', $boorecipe_premium_post_types, 'verify_user_rating_posted', 999 );

		// Add the filter to check whether the comment meta data has been filled
		$this->loader->add_action( 'comment_text', $boorecipe_premium_post_types, 'add_star_reviews_to_posted_comments', 999 );


		$this->loader->add_action( 'edit_comment', $boorecipe_premium_post_types, 'extend_comment_edit_meta_fields', 999 );


		$this->loader->add_filter( 'boorecipe_recipe_add_image_sizes_array', $boorecipe_premium_post_types, 'recipe_add_image_sizes_for_premium_features' );
	}

	/**
	 * Register all of the hooks related to the shortcode functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_shortcode_hooks() {
		// Adding New Shortcodes
		$plugin_premium_shortcode = new Boorecipe_Premium_Shortcodes( $this->get_parent_plugin_name(), $this->get_version() );

		$this->loader->add_shortcode( "recipe_embed", $plugin_premium_shortcode, "recipe_embed" );

		$this->loader->add_filter( 'shortcode_atts_recipes_browse_array', $plugin_premium_shortcode, 'filter_shortcode_atts_recipes_browse_array', 10, 1 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_premium_public = new Boorecipe_Premium_Public( $this->get_parent_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_premium_public, 'enqueue_styles' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_premium_public, 'dequeue_styles', 999 );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_premium_public, 'enqueue_scripts' );


		// We are using same js from base plugin, so, no need to deque
		//		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_premium_public, 'dequeue_scripts' ,999);
	}

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_template_hooks() {
		$plugin_premium_templates = new Boorecipe_Premium_Template_Functions( $this->get_parent_plugin_name(), $this->get_version() );


		$this->loader->add_filter( 'boorecipe_template_additional_paths', $plugin_premium_templates, 'add_template_path' );
	}

	/*
	 * Returns the Parent Plugin Name
	 *
	 * @return string
	 */

	/**
	 * Register all of the hooks related to single templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_single_template_hooks() {
		$single_premium_templates = new Boorecipe_Premium_Single_Template_Functions( $this->get_parent_plugin_name(), $this->get_version() );

		/*
		 * Single Recipe Actions and Filters
		 */

		/*
		 * Single Recipe Media
		 */

		$this->loader->add_action( 'boorecipe_single_media', $single_premium_templates, 'recipe_image_slider', 10, 2 );

		$this->loader->add_action( 'boorecipe_single_media', $single_premium_templates, 'recipe_video_section', 10, 2 );

		/*
		 * Single Recipe Meta
		 */

		// Recipe Taxonomy
		$this->loader->add_action( 'boorecipe_single_meta_taxonomy', $single_premium_templates, 'the_taxonomy_cuisine', 10, 2 );

		// Recipe Key Point
		$this->loader->add_action( 'boorecipe_single_meta_key_point_style_1', $single_premium_templates, 'the_taxonomy_cooking_method', 15, 2 );

		/*
		 * Single Recipe Body
		 */

		$this->loader->add_action( 'boorecipe_single_body', $single_premium_templates, 'recipe_tool_display', 10, 2 );

		$this->loader->add_action( 'boorecipe_single_body', $single_premium_templates, 'cooking_methods_display', 10, 2 );

		$this->loader->add_action( 'boorecipe_single_body_after', $single_premium_templates, 'ratings_display', 10, 2 );

		$this->loader->add_action( 'boorecipe_single_body_after', $single_premium_templates, 'author_box', 11, 2 );

		$this->loader->add_action( 'boorecipe_single_body_after', $single_premium_templates, 'related_recipes_section', 13, 2 );


		$this->loader->add_filter( 'boorecipe_before_showing_featured_image', $single_premium_templates, 'is_recipe_have_video_or_image', 10, 2 );


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

		// Time functions are now handled by the unified system in the free plugin
		// For Style 2, the time display is moved to body_before section
		$this->loader->add_action( 'boorecipe_single_body_before', $single_premium_templates, 'sub_section_meta_time_style_2', 9, 2 );


		/* Options Hooks */
		$this->loader->add_action( 'boorecipe_single_media_before', $single_premium_templates, 'single_media_before', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_media_after', $single_premium_templates, 'single_media_after', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_head_before', $single_premium_templates, 'single_head_before', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_head_after', $single_premium_templates, 'single_head_after', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_before', $single_premium_templates, 'single_meta_before', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_meta_after', $single_premium_templates, 'single_meta_after', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_body_before', $single_premium_templates, 'single_body_before', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_body_after', $single_premium_templates, 'single_body_after', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_article_after_start', $single_premium_templates, 'single_article_before_start', 10, 2 );
		$this->loader->add_action( 'boorecipe_single_article_after_end', $single_premium_templates, 'single_article_after_end', 10, 2 );


		/*
		 * Recipe Style : 3
		 */
		$this->loader->add_filter( 'boorecipe_single_recipe_layout_class', $single_premium_templates, 'single_recipe_layout_class' );

		$this->loader->add_action( 'boorecipe_single_body_before', $single_premium_templates, 'add_boo_recipe_details_wrapper' );
		$this->loader->add_action( 'boorecipe_single_body_after', $single_premium_templates, 'close_boo_recipe_details_wrapper', 12 );
	}

	/**
	 * Register all of the hooks related to archive templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_archive_template_hooks() {
		$archive_premium_templates = new Boorecipe_Premium_Archive_Template_Functions( $this->get_parent_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'boorecipe_archive_recipe_key_points', $archive_premium_templates, 'archive_recipe_key_points_total_time', 10, 2 );

		$this->loader->add_action( 'boorecipe_archive_recipe_content', $archive_premium_templates, 'archive_recipe_author_name', 8, 2 );

		$this->loader->add_filter( 'boorecipe_filter_archive_recipe_card_classes', $archive_premium_templates, 'filter_archive_recipe_card_classes' );

		$this->loader->add_filter( 'boorecipe_filter_archive_recipe_wrap_classes', $archive_premium_templates, 'filter_archive_recipe_wrap_classes' );
	}

	/**
	 * Register all of the hooks related to single templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_aside_template_hooks() {
	}

	/**
	 * Register all of the hooks related to single templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_widget_template_hooks() {
		$widget_premium_templates = new Boorecipe_Premium_Widget_Template_Functions( $this->get_parent_plugin_name(), $this->get_version() );

		// Widgets
		$this->loader->add_action( 'boorecipe_widget_search_form_fields', $widget_premium_templates, 'search_form_cuisine_field', 8 );
	}

	/**
	 * Register all of the hooks related to widgets.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	private function define_widget_hooks() {
		$plugin_premium_widgets = new Boorecipe_Premium_Widgets();

		$this->loader->add_action( 'widgets_init', $plugin_premium_widgets, 'widgets_init' );
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
	 * @return    Boorecipe_Premium_Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

}

