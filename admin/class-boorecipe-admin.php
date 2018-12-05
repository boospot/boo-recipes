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
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

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
	public function data_update_menu(){



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
//		$config_submenu = array(
//
//			// Required, menu or metabox
//			'type'            => 'menu',
//			// Required, meta box id, unique per page, to save: get_option( id )
//			'id'              => $this->plugin_name . '-options',
//			// Required, sub page to your options page
//			'menu'            => 'options-general.php',
//			// Required for submenu
//			'submenu'         => true,
//			//The name of this page
//			'title'           => __( 'Boo Recipe Settings', 'boorecipe' ),
//			// The capability needed to view the page
//			'capability'      => 'manage_options',
//			'plugin_basename' => plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' ),
//			'settings_link'   => 'https://google.com'
//
//		);


		$config_submenu = array(

			// Required, menu or metabox
			'type'            => 'menu',
			// Required, meta box id, unique per page, to save: get_option( id )
			'id'              => $this->plugin_name . '-options',
			// //The Menu Title in Wp Admin
			'menu_title'      => __( 'Boo Recipe', 'boorecipe' ),
			// Required for submenu
			'submenu'         => true,
			//The name of this page
			'title'           => __( 'Settings', 'boorecipe' ),
			// The capability needed to view the page
			'capability'      => 'manage_options',
			// plugin_basename required to add plugin action links
			'plugin_basename' => plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' ),
			// Settings Link in Plugin Action Links
			'settings_link'   => array(
				array(
					'text' => __( 'Settings', 'boorecipe' ),
					'type' => 'default',
				),
				array(
					'text' => __( 'Premium Plugin', 'boorecipe' ),
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
			'title'  => __( 'Recipe Single', 'boorecipe' ),
			'icon'   => 'dashicons-carrot',
			'fields' => apply_filters( 'boorecipe_filter_options_recipe_single', array(

				array(
					'id'          => 'color_accent',
					'type'        => 'color',
					'title'       => __( 'Accent Color', 'boorecipe' ),
					'description' => __( 'This will the theme color for the recipe', 'boorecipe' ),
					'default'     => '#71A866',
				),

				array(
					'id'          => 'color_secondary',
					'type'        => 'color',
					'title'       => __( 'Secondary Color', 'boorecipe' ),
					'description' => __( 'This will be the color for secondary elements (usually in contrast of accent)', 'boorecipe' ),
					'default'     => '#e8f1e6',
					'rgba'        => true,
				),

				array(
					'id'      => 'color_icon',
					'type'    => 'color',
					'title'   => __( 'Icon Color', 'boorecipe' ),
					'label'   => __( 'This will be the color for icons', 'boorecipe' ),
					'default' => '#71A866',
					'rgba'    => true,
				),


				array(
					'id'      => 'color_border',
					'type'    => 'color',
					'title'   => __( 'Border Color', 'boorecipe' ),
					'label'   => __( 'This will be the color for borders in elements', 'boorecipe' ),
					'default' => '#e5e5e5',
					'rgba'    => true,
				),

				array(
					'id'          => 'recipe_style',
					'type'        => 'image_select',
					'title'       => __( 'Recipe Style', 'boorecipe' ),
					'options'     => apply_filters( 'boorecipe_filter_options_recipe_single_style', array(
						'style1' => 'https://dummyimage.com/100x80/2ecc70/fff.gif&text=Style1',
					) ),
					'radio'       => true,
					'default'     => 'style1',
					'description' => __( 'More Styles in Premium Version', 'boorecipe' ),
				),

				array(
					'id'      => 'show_nutrition',
					'type'    => 'switcher',
					'title'   => __( 'Show Nutrition? (Global)', 'boorecipe' ),
					'label'   => __( 'Do you want to show Nutrition info in individual Recipe?', 'boorecipe' ),
					'default' => 'yes',
				),

				array(
					'id'      => 'show_icons',
					'type'    => 'switcher',
					'title'   => __( 'Show Icons?', 'boorecipe' ),
					'label'   => __( 'Do you want to show icons in individual Recipe?', 'boorecipe' ),
					'default' => 'yes',
				),

				array(
					'id'      => 'show_key_point_label',
					'type'    => 'switcher',
					'title'   => __( 'Show Labels for Key Points?', 'boorecipe' ),
					'label'   => __( 'Do you want to show labels for key points in individual Recipe?', 'boorecipe' ),
					'default' => 'yes',
				),


				array(
					'id'      => 'ingredient_side',
					'type'    => 'switcher',
					'title'   => __( 'Ingredients by the Side', 'boorecipe' ),
					'label'   => __( 'Do you Want to show ingredients by the side?', 'boorecipe' ),
					'default' => 'no',
				),

				array(
					'id'      => 'nutrition_side',
					'type'    => 'switcher',
					'title'   => __( 'Nutrition by the Side', 'boorecipe' ),
					'label'   => __( 'Do you Want to show nutrition by the side?', 'boorecipe' ),
					'default' => 'yes',
				),


				array(
					'id'      => 'show_share_buttons',
					'type'    => 'switcher',
					'title'   => __( 'Show Share Buttons?', 'boorecipe' ),
					'label'   => __( 'Do you Want to show share buttons on recipe page?', 'boorecipe' ),
					'default' => $this->get_default_options( 'show_share_buttons' ),
				),

				array(
					'id'      => 'show_author',
					'type'    => 'switcher',
					'title'   => __( 'Show Author', 'boorecipe' ),
					'label'   => __( 'Do you Want to show author name on recipe page?', 'boorecipe' ),
					'default' => 'yes',
				),

				array(
					'id'      => 'show_published_date',
					'type'    => 'switcher',
					'title'   => __( 'Show Published Date', 'boorecipe' ),
					'label'   => __( 'Do you want to show published date on recipe page?', 'boorecipe' ),
					'default' => 'no',
				),

				array(
					'id'          => 'featured_image_height',
					'type'        => 'text',
					'title'       => __( 'Featured image height', 'boorecipe' ),
//					'after'       => __("You will need to re-generate thumbnails after changing this value for existing recipes", "boorecipe"),
					'description' => __( 'Maximum height of the recipe image', 'boorecipe' ),
					'default'     => '576',
					'sanitize'    => 'boorecipe_sanitize_absint',

				),

				array(
					'id'          => 'recipe_default_img_url',
					'type'        => 'image',
					'title'       => __( 'Recipe default image', 'boorecipe' ),
					'description' => __( 'Paste the full url to the image you want to use', 'boorecipe' ),
				),

				array(
					'id'          => 'layout_max_width',
					'type'        => 'number',
					'title'       => __( 'Layout Max Width', 'boorecipe' ),
//					'after'       => __("You will need to re-generate thumbnails after changing this value for existing recipes", "boorecipe"),
					'description' => __( 'in pixels', 'boorecipe' ),
					'default'     => '1048',
					'sanitize'    => 'boorecipe_sanitize_absint',

				),

				array(
					'id'      => 'recipe_layout',
					'type'    => 'image_select',
					'title'   => __( 'Recipe Layout', 'boorecipe' ),
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
					'title'       => __( 'Recipe Slug', 'boorecipe' ),
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

			) ),
		);

		/*
		 * Recipe Archive
		 */
		$options_fields['recipe_archive'] = array(
			'id'     => 'recipe_archive',
			'name'   => 'recipe_archive',
			'title'  => __( 'Recipe Archive', 'boorecipe' ),
			'icon'   => 'dashicons-layout',
			'fields' => apply_filters( 'boorecipe_filter_options_recipe_archive', array(

				array(
					'id'       => 'recipes_per_page',
					'type'     => 'number',
					'title'    => __( 'Recipes Per Page', 'boorecipe' ),
					'default'  => $this->get_default_options( 'recipes_per_page' ),
					'sanitize' => 'boorecipe_sanitize_absint',

				),

				array(
					'id'       => 'recipes_per_row',
					'type'     => 'select',
					'title'    => __( 'Recipes Per Row', 'boorecipe' ),
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
					'id'      => 'recipe_archive_layout',
					'type'    => 'select',
					'title'   => __( 'Recipes Archive Layout', 'boorecipe' ),
					'options' => apply_filters( 'boorecipe_filter_options_recipe_archive_layout', array(
						'grid' => __( 'Grid', 'boorecipe' ),
						'list' => __( 'List', 'boorecipe' ),
					) ),
					'default' => $this->get_default_options( 'recipe_archive_layout' ),
				),

				array(
					'id'          => 'show_in_masonry',
					'type'        => 'switcher',
					'title'       => __( 'Show Recipe cards in Masonry?', 'boorecipe' ),
					'default'     => $this->get_default_options( 'show_in_masonry' ),
					'description' => __( 'If enabled, Layout Switcher will auto disable on front end', 'boorecipe' ),
				),

				array(
					'id'          => 'show_layout_switcher',
					'type'        => 'switcher',
					'title'       => __( 'Show Layout Switcher?', 'boorecipe' ),
					'description' => __( 'This option only available for List and Grid view', 'boorecipe' ),
					'default'     => $this->get_default_options( 'show_layout_switcher' ),
				),

				array(
					'id'      => 'heading_for_archive_title',
					'type'    => 'select',
					'title'   => __( 'Heading Tag for Recipes Archive', 'boorecipe' ),
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
					'id'          => 'color_archive_title',
					'type'        => 'color',
					'title'       => __( 'Recipe Title Color', 'boorecipe' ),
					'description' => __( 'This will default to theme link color', 'boorecipe' ),
					'default'     => $this->get_default_options( 'color_archive_title' ),
				),

				array(
					'id'      => 'color_archive_excerpt',
					'type'    => 'color',
					'title'   => __( 'Recipe Excerpt Color', 'boorecipe' ),
					'default' => $this->get_default_options( 'color_archive_excerpt' ),

				),

				array(
					'id'      => 'color_card_bg',
					'type'    => 'color',
					'title'   => __( 'Cards Background Color', 'boorecipe' ),
					'default' => $this->get_default_options( 'color_card_bg' ),
					'rgba'    => true,
				),

				array(
					'id'      => 'color_archive_keys',
					'type'    => 'color',
					'title'   => __( 'Key Points Text Color', 'boorecipe' ),
					'default' => $this->get_default_options( 'color_archive_keys' ),

				),

				// Expected insertion of premium options

				array(
					'id'          => 'archive_layout_max_width',
					'type'        => 'number',
					'title'       => __( 'Archive Layout Max Width', 'boorecipe' ),
					'description' => __( 'in pixels', 'boorecipe' ),
					'default'     => $this->get_default_options( 'archive_layout_max_width' ),
					'sanitize'    => 'boorecipe_sanitize_absint',

				),


				array(
					'id'      => 'override_theme_pagination_style',
					'type'    => 'switcher',
					'title'   => __( 'Override Pagination Styling?', 'boorecipe' ),
					'label'   => __( 'Do you want to override theme styling for pagination?', 'boorecipe' ),
					'default' => $this->get_default_options( 'override_theme_pagination_style' ),
				),

				array(
					'id'      => 'show_archive_excerpt',
					'type'    => 'switcher',
					'title'   => __( 'Show Archive Excerpt', 'boorecipe' ),
					'label'   => __( 'Do you want to show archive excerpt?', 'boorecipe' ),
					'default' => $this->get_default_options( 'show_archive_excerpt' ),
				),

				array(
					'id'      => 'show_search_form',
					'type'    => 'switcher',
					'title'   => __( 'Show Search Form on archive page?', 'boorecipe' ),
					'label'   => __( 'If enabled, Search form will be added to recipes archive page ', 'boorecipe' ),
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
			'title'  => __( 'Search Form', 'boorecipe' ),
			'icon'   => 'dashicons-search',
			'fields' => apply_filters( 'recipe_options_search_form_section_fields_array', array(

				array(
					'id'      => 'form_bg_color',
					'type'    => 'color',
					'title'   => __( 'Form background Color', 'boorecipe' ),
					'default' => $this->get_default_options( 'form_bg_color' ),
					'rgba'    => true,
//					'description'   => __('This will default to theme link color','boorecipe'),
				),

				array(
					'id'      => 'form_button_bg_color',
					'type'    => 'color',
					'title'   => __( 'Button background color', 'boorecipe' ),
					'default' => $this->get_default_options( 'form_button_bg_color' ),
					'rgba'    => true,
				),

				array(
					'id'      => 'form_button_text_color',
					'type'    => 'color',
					'title'   => __( 'Button text color', 'boorecipe' ),
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
			'title'  => __( 'Widget Settings', 'boorecipe' ),
			'icon'   => 'dashicons-list-view',
			'fields' => array(

				array(
					'id'          => 'recipe_widget_img_width',
					'type'        => 'number',
					'title'       => __( 'Recipe Widget: Image width', 'boorecipe' ),
					'after'       => __( "in pixels", "boorecipe" ),
					'description' => __( 'its for widget area', 'boorecipe' ),
					'default'     => $this->get_default_options( 'recipe_widget_img_width' ),
					'sanitize'    => 'boorecipe_sanitize_absint',

				),

				array(
					'id'      => 'recipe_widget_bg_color',
					'type'    => 'color',
					'title'   => __( 'Recipe Widget: Background color', 'boorecipe' ),
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
			'title'  => __( 'Settings Backup', 'boorecipe' ),
			'icon'   => 'dashicons-controls-repeat',
			'fields' => array(

				array(
					'id'    => 'boorecipe_options_backup_restore',
					'type'  => 'backup',
					'title' => __( 'Settings Backup and/or Restore', 'boorecipe' ),
				),

			)
		);

		/*
		 * Premium Plugin
		 */
		$options_fields['recipe_plugin_activation'] = array(
			'id'     => 'recipe_plugin_activation',
			'name'   => 'recipe_plugin_activation',
			'title'  => __( 'Premium Plugin', 'boorecipe' ),
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
			'title'  => __( 'Custom CSS', 'boorecipe' ),
			'icon'   => 'dashicons-editor-code',
			'fields' => apply_filters( 'boorecipe_filter_options_custom_css_section', array(

					array(
						'id'          => 'custom_css_editor',
						'type'        => 'ace_editor',
						'title'       => __( 'Your Custom CSS', 'boorecipe' ),
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

				)
			)
		);

		/*
		 * Uninstall
		 */
		$options_fields['uninstall_section'] = array(
			'id'     => 'uninstall_section',
			'name'   => 'uninstall_section',
			'title'  => __( 'Uninstall', 'boorecipe' ),
			'icon'   => 'dashicons-dismiss',
			'fields' => apply_filters( 'boorecipe_filter_options_uninstall_section', array(

					array(
						'id'          => 'uninstall_delete_options',
						'type'        => 'switcher',
						'title'       => __( 'Delete Plugin Options', 'boorecipe' ),
						'description' => __( 'Delete all plugin options data at uninstall?', 'boorecipe' ),
						'help'        => __( 'green = Yes & red = No', 'boorecipe' ),
						'default'     => $this->get_default_options( 'uninstall_delete_options' ),
					),

					array(
						'id'          => 'uninstall_delete_meta',
						'type'        => 'switcher',
						'title'       => __( 'Delete Recipes Data', 'boorecipe' ),
						'description' => __( 'Delete all recipes meta data at uninstall?', 'boorecipe' ),
						'help'        => __( 'green = Yes & red = No', 'boorecipe' ),
						'default'     => $this->get_default_options( 'uninstall_delete_mata' ),
					),



				)
			)
		);


//
//		$options_fields['group'] =  array(
//			'type'    => 'group',
//			'id'      => 'my_group',
//			'name'    => 'my_group',
//			'icon'   => 'dashicons-dismiss',
//			'title'   => esc_html__( 'Gruop field', 'plugin-name' ),
//			'options' => array(
//				'repeater'          => false,
//				'accordion'         => true,
//				'button_title'      => 'Add new',
//				'accordion_title'   => esc_html__( 'Accordion Title', 'plugin-name' ),
//				'limit'             => 50,
//				'sortable'          => true,
//			),
//			'fields'  => array(
//				array(
//					'id'      => 'text_group',
//					'type'    => 'text',
//					'title'   => esc_html__( 'Text', 'plugin-name' ),
//					'attributes' => array(
//						// mark this field az title, on type this will change group item title
//						'data-title' => 'title',
//						'placeholder' => esc_html__( 'Some text', 'plugin-name' ),
//					),
//				),
//				array(
//					'id'      => 'switcher_group',
//					'type'    => 'switcher',
//					'title'   => esc_html__( 'Switcher', 'plugin-name' ),
//					'default' => 'yes',
//				),
//				array(
//					'id'             => 'emails',
//					'type'           => 'select',
//					'title'          => esc_html__( 'Users Email (callback)', 'plugin-name' ),
//					'query'          => array(
//						'type'          => 'callback',
//						'function'      => array( $this, 'get_all_emails' ),
//						'args'          => array() // WordPress query args
//					),
//					'attributes' => array(
//						'multiple' => 'multiple',
//						'style'    => 'width: 200px; height: 56px;',
//					),
//					'class'       => 'chosen',
//				),
//				array(
//					'id'      => 'textarea_group',
//					'type'    => 'textarea',
//					'class'   => 'some-class',
//					'title'   => esc_html__( 'Textarea', 'plugin-name' ),
//					'default' => esc_html__( 'Some text', 'plugin-name' ),
//					'after'   => '<mute>' . esc_html__( 'Some info: ', 'plugin-name' ) . '</mute>',
//				),
//			),
//		);


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
