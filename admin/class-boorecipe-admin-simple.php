<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Boorecipe
 * @subpackage Boorecipe/admin
 * @author     Rao Abid <raoabid491@gmail.com>
 */
class Boorecipe_Admin_Simple {

	protected $settings_api;
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 *
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->prefix = Boorecipe_Globals::get_meta_prefix();

	}

	/**
	 * Register the stylesheets for the admin area.
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

//		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/boorecipe-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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


		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/boorecipe-admin.js', array( 'jquery' ), $this->version, false );


	}


	/**
	 * Shall use this to add data update functionality
	 */
	public function data_update_menu() {


	}


	/**
	 *
	 */
	public function admin_menu_simple() {

		$config_array = array(
			'options_id' => $this->plugin_name . '-options-new',
			'tabs'       => true,
			'menu'       => $this->get_settings_menu(),
			'links'      => $this->get_settings_links(),
			'sections'   => $this->get_settings_sections(),
			'fields'     => $this->get_settings_fields()
		);


		$this->settings_api = new Boo_Settings_Helper( $config_array );

		//set menu settings
//			$this->settings_api->set_menu( $this->get_settings_menu() );

		//set the plugin action links
		$this->settings_api->set_links( $this->get_settings_links() );

		//set the settings
//			$this->settings_api->set_sections( $this->get_settings_sections_new() );

		// set fields
//			$this->settings_api->set_fields( $this->get_settings_fields_new() );

		//initialize settings
		$this->settings_api->admin_init();

//			add_options_page( 'WeDevs Settings API', 'WeDevs Settings API', 'delete_posts', 'settings_api_test', array($this, 'plugin_page') );
	}

	function get_settings_menu() {
		$config_menu = array(
			//The name of this page
			'page_title'      => __( 'New Settings', 'boorecipe' ),
			// //The Menu Title in Wp Admin
			'menu_title'      => __( 'New Settings', 'boorecipe' ),
			// The capability needed to view the page
			'capability'      => 'manage_options',
			// Slug for the Menu page
			'slug'            => 'boo-helper-slug',
			// dashicons id or url to icon
			// https://developer.wordpress.org/resource/dashicons/
			'icon'            => 'dashicons-performance',
			// Required for submenu
			'submenu'         => true,
			// position
//			'position'   => 10,
			// For sub menu, we can define parent menu slug (Defaults to Options Page)
			'parent'          => 'edit.php?post_type=boo_recipe',
			// plugin_basename required to add plugin action links
			'plugin_basename' => plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' ),
		);

		return $config_menu;
	}

	function get_settings_links() {
		$links = array(
//				'plugin_basename' => plugin_basename( __FILE__ ),
			'plugin_basename' => plugin_basename( plugin_dir_path( __FILE__ ) . $this->plugin_name . '.php' ),

			// Settings Link in Plugin Action Links


			// Default Settings Links from Menu array
//				'action_links' => true,


			// Admin URL after trailing slash of https://example.com/wp-admin/{url}
//				'action_links' => '?page=boo-helper-slug',

			// array of Settings
			'action_links'    => array(
				array(
					'text' => __( 'Configure', 'boo-helper' ),
					'type' => 'default',
				),
//					array(
//						'text' => __( 'G Forms', 'boo-helper' ),
//						'url'  => 'admin.php?page=gf_edit_forms',
//						'type' => 'internal',
//					),
				array(
					'text' => __( 'Advance Settings', 'boo-helper' ),
					'url'  => 'admin.php?page=boo-helper-slug&tab=wedevs_advanced',
					'type' => 'internal',
				),

				array(
					'text' => __( 'Premium Plugin', 'boo-helper' ),
					'url'  => 'https://boorecipes.com/',
					'type' => 'external',
				),
			),


		);

//			var_dump( $links); die();

		return $links;
	}

	function get_settings_sections() {
		$sections = array(
			array(
				'id'    => $this->prefix . 'recipe_single',
				'title' => __( 'Recipe Single', 'boorecipe' ),
//				'desc'  => 'this is sweet'
			),
			array(
				'id'    => 'recipe_archive',
				'title' => __( 'Recipe Archive', 'boorecipe' ),
			),
			array(
				'id'    => 'recipe_search_form',
				'title' => __( 'Search Form', 'boorecipe' ),
			),
			array(
				'id'    => 'recipe_widgets',
				'title' => __( 'Widget Settings', 'boorecipe' ),
			),
			array(
				'id'    => 'recipe_options_backup_restore',
				'title' => __( 'Settings Backup', 'boorecipe' ),
			),
			array(
				'id'    => 'recipe_plugin_activation',
				'title' => __( 'Premium Plugin', 'boorecipe' ),
			),
			array(
				'id'    => 'custom_css_section',
				'title' => __( 'Custom CSS', 'boorecipe' ),
			),
			array(
				'id'    => 'uninstall_section',
				'title' => __( 'Uninstall', 'boorecipe' ),
			)
		);

		return $sections;
	}

	function get_settings_fields() {
		$options_fields = array();
		/*
* Recipe Individual
*/
		$options_fields[ $this->prefix . 'recipe_single' ] = apply_filters( 'boorecipe_filter_options_recipe_single', array(

			array(
				'id'          => $this->prefix . 'color_accent',
				'type'        => 'color',
				'label'       => __( 'Accent Color', 'boorecipe' ),
				'description' => __( 'This will the theme color for the recipe', 'boorecipe' ),
				'default'     => '#71A866',
			),

			array(
				'id'          => $this->prefix . 'color_secondary',
				'type'        => 'color',
				'label'       => __( 'Secondary Color', 'boorecipe' ),
				'description' => __( 'This will be the color for secondary elements (usually in contrast of accent)', 'boorecipe' ),
				'default'     => '#e8f1e6',
				'rgba'        => true,
			),

			array(
				'id'                => $this->prefix . 'color_icon',
				'type'              => 'color',
				'label'             => __( 'Icon Color', 'boorecipe' ),
				'label_description' => __( 'This will be the color for icons', 'boorecipe' ),
				'default'           => '#71A866',
				'rgba'              => true,
			),

			array(
				'id'                => $this->prefix . 'color_border',
				'type'              => 'color',
				'label'             => __( 'Border Color', 'boorecipe' ),
				'label_description' => __( 'This will be the color for borders in elements', 'boorecipe' ),
				'default'           => '#e5e5e5',
				'rgba'              => true,
			),

			array(
				'id'      => $this->prefix . 'recipe_style',
				'type'    => 'select',
				'label'   => __( 'Recipe Style', 'boorecipe' ),
				'options' => apply_filters( 'boorecipe_filter_options_recipe_single_style', array(
					'style1' => __( 'Style 1', 'boorecipe' )
				) ),
				'radio'   => true,
				'default' => 'style1',
				'desc'    => __( 'More Styles in Premium Version', 'boorecipe' ),
			),

			array(
				'id'                => $this->prefix . 'show_nutrition',
				'type'              => 'select',
				'label'             => __( 'Show Nutrition? (Global)', 'boorecipe' ),
				'label_description' => __( 'Do you want to show Nutrition info in individual Recipe?', 'boorecipe' ),
				'default'           => 'yes',
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'                => $this->prefix . 'show_icons',
				'type'              => 'select',
				'label'             => __( 'Show Icons?', 'boorecipe' ),
				'label_description' => __( 'Do you want to show icons in individual Recipe?', 'boorecipe' ),
				'default'           => 'yes',
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'                => $this->prefix . 'show_key_point_label',
				'type'              => 'select',
				'label'             => __( 'Show Labels for Key Points?', 'boorecipe' ),
				'label_description' => __( 'Do you want to show labels for key points in individual Recipe?', 'boorecipe' ),
				'default'           => 'yes',
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			),


			array(
				'id'                => $this->prefix . 'ingredient_side',
				'type'              => 'select',
				'label'             => __( 'Ingredients by the Side', 'boorecipe' ),
				'label_description' => __( 'Do you Want to show ingredients by the side?', 'boorecipe' ),
				'default'           => 'no',
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'                => $this->prefix . 'nutrition_side',
				'type'              => 'select',
				'label'             => __( 'Nutrition by the Side', 'boorecipe' ),
				'label_description' => __( 'Do you Want to show nutrition by the side?', 'boorecipe' ),
				'default'           => 'yes',
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'                => $this->prefix . 'show_featured_image',
				'type'              => 'select',
				'label'             => __( 'Show Featured Image?', 'boorecipe' ),
				'label_description' => __( 'Some Themes add this to header, you may want to hide the one added by this plugin to avoid duplicated contents', 'boorecipe' ),
				'default'           => $this->get_default_options( 'show_featured_image' ),
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'                => $this->prefix . 'show_recipe_title',
				'type'              => 'select',
				'label'             => __( 'Show Recipe Title?', 'boorecipe' ),
				'label_description' => __( 'Some Themes add this to header, you may want to hide the one added by this plugin to avoid duplicated contents', 'boorecipe' ),
				'default'           => $this->get_default_options( 'show_recipe_title' ),
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'                => $this->prefix . 'show_recipe_publish_info',
				'type'              => 'select',
				'label'             => __( 'Show Recipe Publish info?', 'boorecipe' ),
				'label_description' => __( 'Some Themes add this to header, you may want to hide the one added by this plugin to avoid duplicated contents', 'boorecipe' ),
				'default'           => $this->get_default_options( 'show_recipe_publish_info' ),
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'                => $this->prefix . 'show_share_buttons',
				'type'              => 'select',
				'label'             => __( 'Show Share Buttons?', 'boorecipe' ),
				'label_description' => __( 'Do you Want to show share buttons on recipe page?', 'boorecipe' ),
				'default'           => $this->get_default_options( 'show_share_buttons' ),
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'                => $this->prefix . 'show_author',
				'type'              => 'select',
				'label'             => __( 'Show Author', 'boorecipe' ),
				'label_description' => __( 'Do you Want to show author name on recipe page?', 'boorecipe' ),
				'default'           => 'yes',
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'                => $this->prefix . 'show_published_date',
				'type'              => 'select',
				'label'             => __( 'Show Published Date', 'boorecipe' ),
				'label_description' => __( 'Do you want to show published date on recipe page?', 'boorecipe' ),
				'default'           => 'no',
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'          => $this->prefix . 'featured_image_height',
				'type'        => 'text',
				'label'       => __( 'Featured image height', 'boorecipe' ),
//					'after'       => __("You will need to re-generate thumbnails after changing this value for existing recipes", "boorecipe"),
				'description' => __( 'Maximum height of the recipe image', 'boorecipe' ),
				'default'     => '576',
				'sanitize'    => 'boorecipe_sanitize_absint',

			),

			array(
				'id'          => $this->prefix . 'recipe_default_img_url',
				'type'        => 'media',
				'label'       => __( 'Recipe default image', 'boorecipe' ),
				'description' => __( 'Paste the full url to the image you want to use', 'boorecipe' ),
				'width'       => 768,
				'height'      => 768,
				'max_width'   => 768
			),

			array(
				'id'          => $this->prefix . 'layout_max_width',
				'type'        => 'number',
				'label'       => __( 'Layout Max Width', 'boorecipe' ),
//					'after'       => __("You will need to re-generate thumbnails after changing this value for existing recipes", "boorecipe"),
				'description' => __( 'in pixels', 'boorecipe' ),
				'default'     => '1048',
				'sanitize'    => 'boorecipe_sanitize_absint',

			),

			array(
				'id'      => $this->prefix . 'recipe_layout',
				'type'    => 'select',
				'label'   => __( 'Recipe Layout', 'boorecipe' ),
				'options' => array(
					'full'  => __( 'Full', 'boorecipe' ),
					'left'  => __( 'Left', 'boorecipe' ),
					'right' => __( 'Right', 'boorecipe' ),
				),
				'radio'   => true,
				'default' => 'full',
			),

			array(
				'id'          => $this->prefix . 'recipe_slug',
				'type'        => 'text',
				'label'       => __( 'Recipe Slug', 'boorecipe' ),
				'after'       => sprintf( __( "You will need to re-save %spermalinks%s after changing this value", "boorecipe" ), '<a href=' . get_admin_url() . "options-permalink.php" . ' target="_blank">', '</a>' ),
				'class'       => 'text-class',
				'description' => __( 'the term that appears in url', 'boorecipe' ),
				'default'     => 'recipe',
				'attributes'  => array(
					'rows' => 10,
					'cols' => 5,
				),
				'help'        => 'only use small letters and underscores or dashes',
				'sanitize'    => 'sanitize_key',

			),

		) );
		/*
		 * Recipe Archive
		 */
		$options_fields['recipe_archive'] = apply_filters( 'boorecipe_filter_options_recipe_archive', array(

			array(
				'id'       => $this->prefix . 'recipes_per_page',
				'type'     => 'number',
				'label'    => __( 'Recipes Per Page', 'boorecipe' ),
				'default'  => $this->get_default_options( 'recipes_per_page' ),
				'sanitize' => 'boorecipe_sanitize_absint',
				'options'  => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'       => $this->prefix . 'recipes_per_row',
				'type'     => 'select',
				'label'    => __( 'Recipes Per Row', 'boorecipe' ),
				'options'  => array(
					'1' => __( '1', 'boorecipe' ),
					'2' => __( '2', 'boorecipe' ),
					'3' => __( '3', 'boorecipe' ),
					'4' => __( '4', 'boorecipe' ),
					'5' => __( '5', 'boorecipe' ),
				),
				'after'    => __( 'This option will not take affect for ALL archie layouts', 'boorecipe' ),
				'default'  => $this->get_default_options( 'recipes_per_row' ),
				'sanitize' => 'boorecipe_sanitize_absint'
			),

			array(
				'id'      => $this->prefix . 'recipe_archive_layout',
				'type'    => 'select',
				'label'   => __( 'Recipes Archive Layout', 'boorecipe' ),
				'options' => apply_filters( 'boorecipe_filter_options_recipe_archive_layout', array(
					'grid' => __( 'Grid', 'boorecipe' ),
					'list' => __( 'List', 'boorecipe' ),
				) ),
				'default' => $this->get_default_options( 'recipe_archive_layout' ),
			),

			array(
				'id'          => 'show_in_masonry',
				'type'        => 'select',
				'label'       => __( 'Show Recipe cards in Masonry?', 'boorecipe' ),
				'default'     => $this->get_default_options( 'show_in_masonry' ),
				'description' => __( 'If enabled, Layout Switcher will auto disable on front end', 'boorecipe' ),
				'options'     => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'          => $this->prefix . 'show_layout_switcher',
				'type'        => 'select',
				'label'       => __( 'Show Layout Switcher?', 'boorecipe' ),
				'description' => __( 'This option only available for List and Grid view', 'boorecipe' ),
				'default'     => $this->get_default_options( 'show_layout_switcher' ),
				'options'     => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'      => $this->prefix . 'heading_for_archive_title',
				'type'    => 'select',
				'label'   => __( 'Heading Tag for Recipes Archive', 'boorecipe' ),
				'options' => array(
					'h2' => __( 'h2', 'boorecipe' ),
					'h3' => __( 'h3', 'boorecipe' ),
					'h4' => __( 'h4', 'boorecipe' ),
					'h5' => __( 'h5', 'boorecipe' ),
					'h6' => __( 'h6', 'boorecipe' ),
				),
				'default' => $this->get_default_options( 'heading_for_archive_title' ),
			),


			array(
				'id'          => $this->prefix . 'color_archive_title',
				'type'        => 'color',
				'label'       => __( 'Recipe Title Color', 'boorecipe' ),
				'description' => __( 'This will default to theme link color', 'boorecipe' ),
				'default'     => $this->get_default_options( 'color_archive_title' ),
			),

			array(
				'id'      => $this->prefix . 'color_archive_excerpt',
				'type'    => 'color',
				'label'   => __( 'Recipe Excerpt Color', 'boorecipe' ),
				'default' => $this->get_default_options( 'color_archive_excerpt' ),

			),

			array(
				'id'      => $this->prefix . 'color_card_bg',
				'type'    => 'color',
				'label'   => __( 'Cards Background Color', 'boorecipe' ),
				'default' => $this->get_default_options( 'color_card_bg' ),
				'rgba'    => true,
			),

			array(
				'id'      => '$this->prefix .color_archive_keys',
				'type'    => 'color',
				'label'   => __( 'Key Points Text Color', 'boorecipe' ),
				'default' => $this->get_default_options( 'color_archive_keys' ),

			),

			// Expected insertion of premium options

			array(
				'id'          => $this->prefix . 'archive_layout_max_width',
				'type'        => 'number',
				'label'       => __( 'Archive Layout Max Width', 'boorecipe' ),
				'description' => __( 'in pixels', 'boorecipe' ),
				'default'     => $this->get_default_options( 'archive_layout_max_width' ),
				'sanitize'    => 'boorecipe_sanitize_absint',

			),


			array(
				'id'                => $this->prefix . 'override_theme_pagination_style',
				'type'              => 'select',
				'label'             => __( 'Override Pagination Styling?', 'boorecipe' ),
				'label_description' => __( 'Do you want to override theme styling for pagination?', 'boorecipe' ),
				'default'           => $this->get_default_options( 'override_theme_pagination_style' ),
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'                => $this->prefix . 'show_archive_excerpt',
				'type'              => 'select',
				'label'             => __( 'Show Archive Excerpt', 'boorecipe' ),
				'label_description' => __( 'Do you want to show archive excerpt?', 'boorecipe' ),
				'default'           => $this->get_default_options( 'show_archive_excerpt' ),
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'                => $this->prefix . 'show_search_form',
				'type'              => 'select',
				'label'             => __( 'Show Search Form on archive page?', 'boorecipe' ),
				'label_description' => __( 'If enabled, Search form will be added to recipes archive page ', 'boorecipe' ),
				'default'           => $this->get_default_options( 'show_search_form' ),
				'options'           => array( 'yes' => 'Yes', 'no' => 'No' ),
			)


		) );
		/*
	 * Search Form
	 */
		$options_fields['recipe_search_form'] = apply_filters( 'recipe_options_search_form_section_fields_array', array(

			array(
				'id'      => $this->prefix . 'form_bg_color',
				'type'    => 'color',
				'label'   => __( 'Form background Color', 'boorecipe' ),
				'default' => $this->get_default_options( 'form_bg_color' ),
				'rgba'    => true,
//					'description'   => __('This will default to theme link color','boorecipe'),
			),

			array(
				'id'      => $this->prefix . 'form_button_bg_color',
				'type'    => 'color',
				'label'   => __( 'Button background color', 'boorecipe' ),
				'default' => $this->get_default_options( 'form_button_bg_color' ),
				'rgba'    => true,
			),

			array(
				'id'      => $this->prefix . 'form_button_text_color',
				'type'    => 'color',
				'label'   => __( 'Button text color', 'boorecipe' ),
				'default' => $this->get_default_options( 'form_button_text_color' ),
			),

		) );
		/*
		 * Widget Settings
		 */
		$options_fields['recipe_widgets'] = array(

			array(
				'id'          => $this->prefix . 'recipe_widget_img_width',
				'type'        => 'number',
				'label'       => __( 'Recipe Widget: Image width', 'boorecipe' ),
				'after'       => __( "in pixels", "boorecipe" ),
				'description' => __( 'its for widget area', 'boorecipe' ),
				'default'     => $this->get_default_options( 'recipe_widget_img_width' ),
				'sanitize'    => 'boorecipe_sanitize_absint',

			),

			array(
				'id'      => $this->prefix . 'recipe_widget_bg_color',
				'type'    => 'color',
				'label'   => __( 'Recipe Widget: Background color', 'boorecipe' ),
				'default' => $this->get_default_options( 'recipe_widget_bg_color' ),
				'rgba'    => true,
			),

		);
		/*
		 * Settings Backup
		 */
		$options_fields['recipe_options_backup_restore'] = array(

			array(
				'id'    => $this->prefix . 'boorecipe_options_backup_restore',
				'type'  => 'backup',
				'label' => __( 'Settings Backup and/or Restore', 'boorecipe' ),
			),

		);

		/*
		 * Premium Plugin
		 */
		$options_fields['recipe_plugin_activation'] = apply_filters( 'boorecipe_options_plugin_activation_section', array(
			array(
				'id'    => $this->prefix . 'plugin_activation_content',
				'type'  => 'html',
				'class' => 'class-name', // for all fieds
				'desc'  => '<p>Enter all the details here about the features of your premium plugin<br/>
	<a href="#">GET YOUR PLUGIN</a></p>',
			),

		) );
		/*
		 * Custom CSS
		 */
		$options_fields['custom_css_section'] = apply_filters( 'boorecipe_filter_options_custom_css_section', array(

			array(
				'id'          => $this->prefix . 'custom_css_editor',
				'type'        => 'textarea',
				'label'       => __( 'Your Custom CSS', 'boorecipe' ),
				'options'     => array(
					'theme'                     => 'ace/theme/monokai',
					'mode'                      => 'ace/mode/css',
					'showGutter'                => true,
					'showPrintMargin'           => true,
					'enableBasicAutocompletion' => true,
					'enableSnippets'            => true,
					'enableLiveAutocompletion'  => true,
				),
				'attributes'  => array(
					'style' => 'height: 300px; max-width: 700px;',
				),
				'description' => __( 'Add your custom CSS here', 'boorecipe' ),
			),
//

		) );

		/*
		 * Uninstall
		 */
		$options_fields['uninstall_section'] = apply_filters( 'boorecipe_filter_options_uninstall_section', array(

			array(
				'id'          => $this->prefix . 'uninstall_delete_options',
				'type'        => 'select',
				'label'       => __( 'Delete Plugin Options', 'boorecipe' ),
				'description' => __( 'Delete all plugin options data at uninstall?', 'boorecipe' ),
				'help'        => __( 'green = Yes & red = No', 'boorecipe' ),
				'default'     => $this->get_default_options( 'uninstall_delete_options' ),
				'options'     => array( 'yes' => 'Yes', 'no' => 'No' ),
			),

			array(
				'id'          => $this->prefix . 'uninstall_delete_meta',
				'type'        => 'select',
				'label'       => __( 'Delete Recipes Data', 'boorecipe' ),
				'description' => __( 'Delete all recipes meta data at uninstall?', 'boorecipe' ),
				'help'        => __( 'green = Yes & red = No', 'boorecipe' ),
				'default'     => $this->get_default_options( 'uninstall_delete_mata' ),
				'options'     => array( 'yes' => 'Yes', 'no' => 'No' ),
			),


		) );

		return $options_fields;
	}


	/*
	 * Adding Function for Plugin Menu and options page
	 */

	public function get_default_options( $key ) {

		return Boorecipe_Globals::get_default_options( $key );

	}


	public function register_sidebar_widgets() {

		// Single Recipe Sidebar
		register_sidebar( array(
			'name'        => __( 'Recipe Single Sidebar', 'boorecipe' ),
			'id'          => 'recipe-single-sidebar',
			'description' => __( 'Widgets in this area will be shown on Single Recipe', 'boorecipe' ),
		) );

		// Archive Recipe Sidebar
		register_sidebar( array(
			'name'        => __( 'Recipe Archive Sidebar', 'boorecipe' ),
			'id'          => 'recipe-archive-sidebar',
			'description' => __( 'Widgets in this area will be shown on Recipe Archive pages', 'boorecipe' ),
		) );

	}

	public function include_jupiter_options( $post_array ) {

		$post_array[] = 'boo_recipe';

		return $post_array;
	}

}
