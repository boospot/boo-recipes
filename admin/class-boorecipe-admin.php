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
class Boorecipe_Admin {

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
//
//	/**
//	 * Register the stylesheets for the admin area.
//	 *
//	 * @since    1.0.0
//	 */
//	public function enqueue_styles() {
//
//		/**
//		 * This function is provided for demonstration purposes only.
//		 *
//		 * An instance of this class should be passed to the run() function
//		 * defined in Boorecipe_Loader as all of the hooks are defined
//		 * in that particular class.
//		 *
//		 * The Boorecipe_Loader will then create the relationship
//		 * between the defined hooks and the functions defined in this
//		 * class.
//		 */
//
////		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/boorecipe-admin.css', array(), $this->version, 'all' );
//
//	}
//
//	/**
//	 * Register the JavaScript for the admin area.
//	 *
//	 * @since    1.0.0
//	 */
//	public function enqueue_scripts() {
//
//		/**
//		 * This function is provided for demonstration purposes only.
//		 *
//		 * An instance of this class should be passed to the run() function
//		 * defined in Boorecipe_Loader as all of the hooks are defined
//		 * in that particular class.
//		 *
//		 * The Boorecipe_Loader will then create the relationship
//		 * between the defined hooks and the functions defined in this
//		 * class.
//		 */
//
//
//		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/boorecipe-admin.js', array( 'jquery' ), $this->version, false );
//
//
//	}


	/**
	 * @hooked admin_head
	 */
	public function display_old_settings_admin_notice() {

		$admin_notice = new \WPTRT\AdminNotices\Notices();

		$admin_notice->add(
			'old_settings_notice',                           // Unique ID.
			esc_html__( 'Old Settings Detected!', 'boo-recipes' ),  // The title for this notice.
			sprintf(
				esc_html__( 'It looks like you have not updated the new settings page. Please go to %s and on "Special" tab, then click "Convert Old Settings" button. After Successful conversion, go to %s screen and update meta. Once both steps are done, click "Delete Old Settings" button.', 'boo-recipes' ),
				'<a href="' . admin_url( 'edit.php?post_type=boo_recipe&page=boorecipe-settings&tab=special_section' ) . '">' . esc_html__( 'New Settings Page', 'boo-recipes' ) . '</a>',
				'<a href="' . admin_url( 'edit.php?post_type=boo_recipe&page=boorecipe-update-meta' ) . '">' . esc_html__( 'Update Recipes Meta', 'boo-recipes' ) . '</a>'
			),
			// The content for this notice.
			[
				// Only show notice in the recipe
				'type'    => 'warning',
				'screens' => [ 'boo_recipe_page_boorecipe-options', 'boo_recipe_page_boorecipe-settings' ],
			]
		);

		$admin_notice->boot();

	}

	/*
	 * Adding Function for Plugin Menu and options page
	 */

	public function create_plugin_menu() {

		$options_fields = array();
		/*
		* Create a submenu page under Plugins.
		* Framework also add "Settings" to your plugin in plugins list.
		*/

		$config_submenu = array(

			// Required, menu or metabox
			'type'            => 'menu',
			// Required, meta box id, unique per page, to save: get_option( id )
			'id'              => $this->plugin_name . '-options',
			// //The Menu Title in Wp Admin
			'menu_title'      => __( 'Boo Recipe', 'boo-recipes' ),
			// Required for submenu
			'submenu'         => true,
			//The name of this page
			'title'           => __( 'Old Settings', 'boo-recipes' ),
			// The capability needed to view the page
			'capability'      => 'manage_options',
			// plugin_basename required to add plugin action links
			'plugin_basename' => plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' ),
			// Settings Link in Plugin Action Links
			'settings_link'   => array(
				array(
					'text' => __( 'Settings', 'boo-recipes' ),
					'type' => 'default',
				),
				array(
					'text' => __( 'Premium Plugin', 'boo-recipes' ),
					'url'  => 'https://boorecipes.com/',
					'type' => 'external',
				),
			),
			// dashicons id or url to icon
			// https://developer.wordpress.org/resource/dashicons/
			'icon'            => 'dashicons-performance',
			// For sub menu, we can define parent menu slug
			'parent'          => 'edit.php?post_type=boo_recipe',
			'multilang'       => true,

		);
		/*
		 * Recipe Individual
		 */
		$options_fields['recipe_single'] = array( // This is a Section

			'id'     => 'recipe_single',
			'name'   => 'recipe_single',
			'title'  => __( 'Recipe Single', 'boo-recipes' ),
			'icon'   => 'dashicons-carrot',
			'fields' => apply_filters( 'boorecipe_filter_options_recipe_single', array(

				array(
					'id'          => 'color_accent',
					'type'        => 'color',
					'title'       => __( 'Accent Color', 'boo-recipes' ),
					'description' => __( 'This will the theme color for the recipe', 'boo-recipes' ),
					'default'     => '#71A866',
				),

				array(
					'id'          => 'color_secondary',
					'type'        => 'color',
					'title'       => __( 'Secondary Color', 'boo-recipes' ),
					'description' => __( 'This will be the color for secondary elements (usually in contrast of accent)', 'boo-recipes' ),
					'default'     => '#e8f1e6',
					'rgba'        => true,
				),

				array(
					'id'      => 'color_icon',
					'type'    => 'color',
					'title'   => __( 'Icon Color', 'boo-recipes' ),
					'label'   => __( 'This will be the color for icons', 'boo-recipes' ),
					'default' => '#71A866',
					'rgba'    => true,
				),


				array(
					'id'      => 'color_border',
					'type'    => 'color',
					'title'   => __( 'Border Color', 'boo-recipes' ),
					'label'   => __( 'This will be the color for borders in elements', 'boo-recipes' ),
					'default' => '#e5e5e5',
					'rgba'    => true,
				),

				array(
					'id'          => 'recipe_style',
					'type'        => 'image_select',
					'title'       => __( 'Recipe Style', 'boo-recipes' ),
					'options'     => apply_filters( 'boorecipe_filter_options_recipe_single_style', array(
						'style1' => 'https://dummyimage.com/100x80/2ecc70/fff.gif&text=Style1',
					) ),
					'radio'       => true,
					'default'     => 'style1',
					'description' => __( 'More Styles in Premium Version', 'boo-recipes' ),
				),

				array(
					'id'      => 'show_nutrition',
					'type'    => 'switcher',
					'title'   => __( 'Show Nutrition? (Global)', 'boo-recipes' ),
					'label'   => __( 'Do you want to show Nutrition info in individual Recipe?', 'boo-recipes' ),
					'default' => 'yes',
				),

				array(
					'id'      => 'show_icons',
					'type'    => 'switcher',
					'title'   => __( 'Show Icons?', 'boo-recipes' ),
					'label'   => __( 'Do you want to show icons in individual Recipe?', 'boo-recipes' ),
					'default' => 'yes',
				),

				array(
					'id'      => 'show_key_point_label',
					'type'    => 'switcher',
					'title'   => __( 'Show Labels for Key Points?', 'boo-recipes' ),
					'label'   => __( 'Do you want to show labels for key points in individual Recipe?', 'boo-recipes' ),
					'default' => 'yes',
				),


				array(
					'id'      => 'ingredient_side',
					'type'    => 'switcher',
					'title'   => __( 'Ingredients by the Side', 'boo-recipes' ),
					'label'   => __( 'Do you Want to show ingredients by the side?', 'boo-recipes' ),
					'default' => 'no',
				),

				array(
					'id'      => 'nutrition_side',
					'type'    => 'switcher',
					'title'   => __( 'Nutrition by the Side', 'boo-recipes' ),
					'label'   => __( 'Do you Want to show nutrition by the side?', 'boo-recipes' ),
					'default' => 'yes',
				),

				array(
					'id'      => 'show_featured_image',
					'type'    => 'switcher',
					'title'   => __( 'Show Featured Image?', 'boo-recipes' ),
					'label'   => __( 'Some Themes add this to header, you may want to hide the one added by this plugin to avoid duplicated contents', 'boo-recipes' ),
					'default' => $this->get_default_options( 'show_featured_image' ),
				),

				array(
					'id'      => 'show_recipe_title',
					'type'    => 'switcher',
					'title'   => __( 'Show Recipe Title?', 'boo-recipes' ),
					'label'   => __( 'Some Themes add this to header, you may want to hide the one added by this plugin to avoid duplicated contents', 'boo-recipes' ),
					'default' => $this->get_default_options( 'show_recipe_title' ),
				),

				array(
					'id'      => 'show_recipe_publish_info',
					'type'    => 'switcher',
					'title'   => __( 'Show Recipe Publish info?', 'boo-recipes' ),
					'label'   => __( 'Some Themes add this to header, you may want to hide the one added by this plugin to avoid duplicated contents', 'boo-recipes' ),
					'default' => $this->get_default_options( 'show_recipe_publish_info' ),
				),

				array(
					'id'      => 'show_share_buttons',
					'type'    => 'switcher',
					'title'   => __( 'Show Share Buttons?', 'boo-recipes' ),
					'label'   => __( 'Do you Want to show share buttons on recipe page?', 'boo-recipes' ),
					'default' => $this->get_default_options( 'show_share_buttons' ),
				),

				array(
					'id'      => 'show_author',
					'type'    => 'switcher',
					'title'   => __( 'Show Author', 'boo-recipes' ),
					'label'   => __( 'Do you Want to show author name on recipe page?', 'boo-recipes' ),
					'default' => 'yes',
				),

				array(
					'id'      => 'show_published_date',
					'type'    => 'switcher',
					'title'   => __( 'Show Published Date', 'boo-recipes' ),
					'label'   => __( 'Do you want to show published date on recipe page?', 'boo-recipes' ),
					'default' => 'no',
				),

				array(
					'id'          => 'featured_image_height',
					'type'        => 'text',
					'title'       => __( 'Featured image height', 'boo-recipes' ),
//					'after'       => __("You will need to re-generate thumbnails after changing this value for existing recipes", "boorecipe"),
					'description' => __( 'Maximum height of the recipe image', 'boo-recipes' ),
					'default'     => '576',
					'sanitize'    => 'boorecipe_sanitize_absint',

				),

				array(
					'id'          => 'recipe_default_img_url',
					'type'        => 'image',
					'title'       => __( 'Recipe default image', 'boo-recipes' ),
					'description' => __( 'Paste the full url to the image you want to use', 'boo-recipes' ),
				),

				array(
					'id'          => 'layout_max_width',
					'type'        => 'number',
					'title'       => __( 'Layout Max Width', 'boo-recipes' ),
//					'after'       => __("You will need to re-generate thumbnails after changing this value for existing recipes", "boorecipe"),
					'description' => __( 'in pixels', 'boo-recipes' ),
					'default'     => '1048',
					'sanitize'    => 'boorecipe_sanitize_absint',

				),

				array(
					'id'      => 'recipe_layout',
					'type'    => 'image_select',
					'title'   => __( 'Recipe Layout', 'boo-recipes' ),
					'options' => array(
						'full'  => 'https://dummyimage.com/100x80/2ecc70/fff.gif&text=Full',
						'left'  => 'https://dummyimage.com/100x80/e74c3c/fff.gif&text=Left',
						'right' => 'https://dummyimage.com/100x80/ffbc00/fff.gif&text=Right',
					),
					'radio'   => true,
					'default' => 'full',
				),

				array(
					'id'          => 'recipe_slug',
					'type'        => 'text',
					'title'       => __( 'Recipe Slug', 'boo-recipes' ),
					'after'       => sprintf( __( "You will need to re-save %spermalinks%s after changing this value", "boorecipe" ), '<a href=' . get_admin_url() . "options-permalink.php" . ' target="_blank">', '</a>' ),
					'class'       => 'text-class',
					'description' => __( 'the term that appears in url', 'boo-recipes' ),
					'default'     => 'recipe',
					'attributes'  => array(
						'rows' => 10,
						'cols' => 5,
					),
					'help'        => 'only use small letters and underscores or dashes',
					'sanitize'    => 'sanitize_key',

				),

			) ),
		);

		/*
		 * Recipe Archive
		 */
		$options_fields['recipe_archive'] = array(
			'id'     => 'recipe_archive',
			'name'   => 'recipe_archive',
			'title'  => __( 'Recipe Archive', 'boo-recipes' ),
			'icon'   => 'dashicons-layout',
			'fields' => apply_filters( 'boorecipe_filter_options_recipe_archive', array(

				array(
					'id'       => 'recipes_per_page',
					'type'     => 'number',
					'title'    => __( 'Recipes Per Page', 'boo-recipes' ),
					'default'  => $this->get_default_options( 'recipes_per_page' ),
					'sanitize' => 'boorecipe_sanitize_absint',

				),

				array(
					'id'       => 'recipes_per_row',
					'type'     => 'select',
					'title'    => __( 'Recipes Per Row', 'boo-recipes' ),
					'options'  => array(
						'1' => __( '1', 'boo-recipes' ),
						'2' => __( '2', 'boo-recipes' ),
						'3' => __( '3', 'boo-recipes' ),
						'4' => __( '4', 'boo-recipes' ),
						'5' => __( '5', 'boo-recipes' ),
					),
					'after'    => __( 'This option will not take affect for ALL archie layouts', 'boo-recipes' ),
					'default'  => $this->get_default_options( 'recipes_per_row' ),
					'sanitize' => 'boorecipe_sanitize_absint'
				),

				array(
					'id'      => 'recipe_archive_layout',
					'type'    => 'select',
					'title'   => __( 'Recipes Archive Layout', 'boo-recipes' ),
					'options' => apply_filters( 'boorecipe_filter_options_recipe_archive_layout', array(
						'grid' => __( 'Grid', 'boo-recipes' ),
						'list' => __( 'List', 'boo-recipes' ),
					) ),
					'default' => $this->get_default_options( 'recipe_archive_layout' ),
				),

				array(
					'id'          => 'show_in_masonry',
					'type'        => 'switcher',
					'title'       => __( 'Show Recipe cards in Masonry?', 'boo-recipes' ),
					'default'     => $this->get_default_options( 'show_in_masonry' ),
					'description' => __( 'If enabled, Layout Switcher will auto disable on front end', 'boo-recipes' ),
				),

				array(
					'id'          => 'show_layout_switcher',
					'type'        => 'switcher',
					'title'       => __( 'Show Layout Switcher?', 'boo-recipes' ),
					'description' => __( 'This option only available for List and Grid view', 'boo-recipes' ),
					'default'     => $this->get_default_options( 'show_layout_switcher' ),
				),

				array(
					'id'      => 'heading_for_archive_title',
					'type'    => 'select',
					'title'   => __( 'Heading Tag for Recipes Archive', 'boo-recipes' ),
					'options' => array(
						'h2' => __( 'h2', 'boo-recipes' ),
						'h3' => __( 'h3', 'boo-recipes' ),
						'h4' => __( 'h4', 'boo-recipes' ),
						'h5' => __( 'h5', 'boo-recipes' ),
						'h6' => __( 'h6', 'boo-recipes' ),
					),
					'default' => $this->get_default_options( 'heading_for_archive_title' ),
				),


				array(
					'id'          => 'color_archive_title',
					'type'        => 'color',
					'title'       => __( 'Recipe Title Color', 'boo-recipes' ),
					'description' => __( 'This will default to theme link color', 'boo-recipes' ),
					'default'     => $this->get_default_options( 'color_archive_title' ),
				),

				array(
					'id'      => 'color_archive_excerpt',
					'type'    => 'color',
					'title'   => __( 'Recipe Excerpt Color', 'boo-recipes' ),
					'default' => $this->get_default_options( 'color_archive_excerpt' ),

				),

				array(
					'id'      => 'color_card_bg',
					'type'    => 'color',
					'title'   => __( 'Cards Background Color', 'boo-recipes' ),
					'default' => $this->get_default_options( 'color_card_bg' ),
					'rgba'    => true,
				),

				array(
					'id'      => 'color_archive_keys',
					'type'    => 'color',
					'title'   => __( 'Key Points Text Color', 'boo-recipes' ),
					'default' => $this->get_default_options( 'color_archive_keys' ),

				),

				// Expected insertion of premium options

				array(
					'id'          => 'archive_layout_max_width',
					'type'        => 'number',
					'title'       => __( 'Archive Layout Max Width', 'boo-recipes' ),
					'description' => __( 'in pixels', 'boo-recipes' ),
					'default'     => $this->get_default_options( 'archive_layout_max_width' ),
					'sanitize'    => 'boorecipe_sanitize_absint',

				),


				array(
					'id'      => 'override_theme_pagination_style',
					'type'    => 'switcher',
					'title'   => __( 'Override Pagination Styling?', 'boo-recipes' ),
					'label'   => __( 'Do you want to override theme styling for pagination?', 'boo-recipes' ),
					'default' => $this->get_default_options( 'override_theme_pagination_style' ),
				),

				array(
					'id'      => 'show_archive_excerpt',
					'type'    => 'switcher',
					'title'   => __( 'Show Archive Excerpt', 'boo-recipes' ),
					'label'   => __( 'Do you want to show archive excerpt?', 'boo-recipes' ),
					'default' => $this->get_default_options( 'show_archive_excerpt' ),
				),

				array(
					'id'      => 'show_search_form',
					'type'    => 'switcher',
					'title'   => __( 'Show Search Form on archive page?', 'boo-recipes' ),
					'label'   => __( 'If enabled, Search form will be added to recipes archive page ', 'boo-recipes' ),
					'default' => $this->get_default_options( 'show_search_form' ),
				)


			) )
		);

		/*
		 * Search Form
		 */
		$options_fields['recipe_search_form'] = array(
			'id'     => 'recipe_search_form',
			'name'   => 'recipe_search_form',
			'title'  => __( 'Search Form', 'boo-recipes' ),
			'icon'   => 'dashicons-search',
			'fields' => apply_filters( 'recipe_options_search_form_section_fields_array', array(

				array(
					'id'      => 'form_bg_color',
					'type'    => 'color',
					'title'   => __( 'Form background Color', 'boo-recipes' ),
					'default' => $this->get_default_options( 'form_bg_color' ),
					'rgba'    => true,
//					'description'   => __('This will default to theme link color','boo-recipes'),
				),

				array(
					'id'      => 'form_button_bg_color',
					'type'    => 'color',
					'title'   => __( 'Button background color', 'boo-recipes' ),
					'default' => $this->get_default_options( 'form_button_bg_color' ),
					'rgba'    => true,
				),

				array(
					'id'      => 'form_button_text_color',
					'type'    => 'color',
					'title'   => __( 'Button text color', 'boo-recipes' ),
					'default' => $this->get_default_options( 'form_button_text_color' ),
				),

			) )
		);

		/*
		 * Widget Settings
		 */
		$options_fields['recipe_widgets'] = array(
			'id'     => 'recipe_widgets',
			'name'   => 'recipe_widgets',
			'title'  => __( 'Widget Settings', 'boo-recipes' ),
			'icon'   => 'dashicons-list-view',
			'fields' => array(

				array(
					'id'          => 'recipe_widget_img_width',
					'type'        => 'number',
					'title'       => __( 'Recipe Widget: Image width', 'boo-recipes' ),
					'after'       => __( "in pixels", "boorecipe" ),
					'description' => __( 'its for widget area', 'boo-recipes' ),
					'default'     => $this->get_default_options( 'recipe_widget_img_width' ),
					'sanitize'    => 'boorecipe_sanitize_absint',

				),

				array(
					'id'      => 'recipe_widget_bg_color',
					'type'    => 'color',
					'title'   => __( 'Recipe Widget: Background color', 'boo-recipes' ),
					'default' => $this->get_default_options( 'recipe_widget_bg_color' ),
					'rgba'    => true,
				),

			)
		);

		/*
		 * Settings Backup
		 */
		$options_fields['recipe_options_backup_restore'] = array(
			'id'     => 'recipe_options_backup_restore',
			'name'   => 'recipe_options_backup_restore',
			'title'  => __( 'Settings Backup', 'boo-recipes' ),
			'icon'   => 'dashicons-controls-repeat',
			'fields' => array(

				array(
					'id'    => 'boorecipe_options_backup_restore',
					'type'  => 'backup',
					'title' => __( 'Settings Backup and/or Restore', 'boo-recipes' ),
				),

			)
		);

		/*
		 * Premium Plugin
		 */
		$options_fields['recipe_plugin_activation'] = array(
			'id'     => 'recipe_plugin_activation',
			'name'   => 'recipe_plugin_activation',
			'title'  => __( 'Premium Plugin', 'boo-recipes' ),
			'icon'   => 'dashicons-admin-network',
			'fields' => apply_filters( 'boorecipe_options_plugin_activation_section', array(
					array(
						'type'    => 'content',
						'class'   => 'class-name', // for all fieds
						'content' => '<p>Enter all the details here about the features of your premium plugin<br/>
	<a href="#">GET YOUR PLUGIN</a></p>',
					),

				)
			)
		);

		/*
		 * Custom CSS
		 */
		$options_fields['custom_css_section'] = array(
			'id'     => 'custom_css_section',
			'name'   => 'custom_css_section',
			'title'  => __( 'Custom CSS', 'boo-recipes' ),
			'icon'   => 'dashicons-editor-code',
			'fields' => apply_filters( 'boorecipe_filter_options_custom_css_section', array(

					array(
						'id'          => 'custom_css_editor',
						'type'        => 'ace_editor',
						'title'       => __( 'Your Custom CSS', 'boo-recipes' ),
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
						'description' => __( 'Add your custom CSS here', 'boo-recipes' ),
					),
//

				)
			)
		);

		/*
		 * Uninstall
		 */
		$options_fields['uninstall_section'] = array(
			'id'     => 'uninstall_section',
			'name'   => 'uninstall_section',
			'title'  => __( 'Uninstall', 'boo-recipes' ),
			'icon'   => 'dashicons-dismiss',
			'fields' => apply_filters( 'boorecipe_filter_options_uninstall_section', array(

					array(
						'id'          => 'uninstall_delete_options',
						'type'        => 'switcher',
						'title'       => __( 'Delete Plugin Options', 'boo-recipes' ),
						'description' => __( 'Delete all plugin options data at uninstall?', 'boo-recipes' ),
						'help'        => __( 'green = Yes & red = No', 'boo-recipes' ),
						'default'     => $this->get_default_options( 'uninstall_delete_options' ),
					),

					array(
						'id'          => 'uninstall_delete_meta',
						'type'        => 'switcher',
						'title'       => __( 'Delete Recipes Data', 'boo-recipes' ),
						'description' => __( 'Delete all recipes meta data at uninstall?', 'boo-recipes' ),
						'help'        => __( 'green = Yes & red = No', 'boo-recipes' ),
						'default'     => $this->get_default_options( 'uninstall_delete_mata' ),
					),


				)
			)
		);


		/**
		 * instantiate your admin page
		 */
		new Exopite_Simple_Options_Framework( $config_submenu, apply_filters( 'boorecipe_options_args_array', $options_fields ) );
//
	}

	/*
	 * Get Default Options
	 *
	 * @param string $key
	 *
	 * @return string $key
	 *
	 */

	public function get_default_options( $key ) {

		return Boorecipe_Globals::get_default_options( $key );

	}
//
//	/*
//	 * Get Default Labels
//	 *
//	 * @param string $key
//	 *
//	 * @return string $key
//	 *
//	 */
//
//	public function get_default_label( $key ) {
//
//		return Boorecipe_Globals::get_default_label( $key );
//
//	}
}
