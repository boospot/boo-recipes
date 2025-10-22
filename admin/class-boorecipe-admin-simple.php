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
	 *
	 */
	public function admin_delete_settings_handler() {

		// Check Admin referrer
//		check_admin_referer( 'delete_existing_settings_using_ajax' );

		// Verify Nonce
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'delete_existing_settings_using_ajax' ) ) {
			wp_send_json_error( __( 'Security token is invalid. Please refresh the page and try again.', 'boo-recipes' ) );
			die();
		}
		// Check capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Sorry, You do not have sufficient permissions to do this action.', 'boo-recipes' ) );
			die();
		}

		// Get old options
		$old_settings = get_option( 'boorecipe-options' );

		// if no old settings found, send error
		if ( ! $old_settings ) {
			wp_send_json_error( __( 'Sorry, We could not find any old settings', 'boo-recipes' ) );
			die();
		}

		$result = delete_option( 'boorecipe-options' );

		if ( $result ) {
			$response = array(
				'success' => true,
				'data'    => __( 'Old Settings have been successfully deleted.', 'boo-recipes' ) . " " .
				             sprintf( __( 'Page shall reload automatically after %s seconds', 'boo-recipes' ), 10 ),
			);
		} else {
			$response = array(
				'success' => false,
				'data'    => __( 'Sorry, There was an error while deleting old settings. Please try again later', 'boo-recipes' ),
			);

		}


		wp_send_json( json_encode( $response ) );
		die();

	}

	// Old HTML display method removed - now using textarea field

	/**
	 * Log debug information if debug logging is enabled
	 *
	 * @param string $message
	 * @param mixed  $data
	 */
	public function debug_log( $message, $data = null ) {
		if ( $this->get_options_value( 'enable_debug_logging' ) === 'yes' ) {
			$log_message = '[Boo Recipes Debug] ' . $message;
			if ( $data !== null ) {
				$log_message .= ' - Data: ' . print_r( $data, true );
			}
			error_log( $log_message );
		}
	}

	/**
	 * Render system information field
	 *
	 * @param array $args Field arguments
	 */
	public function render_system_info_field( $args ) {
		$system_info = $this->get_system_information_text();
		?>
		<textarea readonly style="width: 100%; height: 400px; font-family: monospace; font-size: 12px; background: #f9f9f9; border: 1px solid #ddd; padding: 10px; resize: vertical;"><?php echo esc_textarea( $system_info ); ?></textarea>
		<?php
		if ( isset( $args['desc'] ) && ! empty( $args['desc'] ) ) {
			echo '<p class="description">' . wp_kses_post( $args['desc'] ) . '</p>';
		}
	}

	/**
	 * Get system information as plain text
	 *
	 * @return string
	 */
	public function get_system_information_text() {
		global $wp_version, $wpdb;
		
		// Get plugin information
		$plugin_data = get_plugin_data( BOORECIPE_BASE_DIR . 'boo-recipes.php' );
		$active_plugins = get_option( 'active_plugins' );
		$active_theme = wp_get_theme();
		
		// Get Boo Recipes settings
		$boorecipe_settings = array();
		$all_options = wp_load_alloptions();
		foreach ( $all_options as $option_name => $option_value ) {
			if ( strpos( $option_name, 'boorecipe_' ) === 0 ) {
				$boorecipe_settings[ $option_name ] = $option_value;
			}
		}
		
		// Get server information
		$server_info = array(
			'PHP Version' => PHP_VERSION,
			'MySQL Version' => $wpdb->get_var( "SELECT VERSION()" ),
			'Server Software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
			'Memory Limit' => ini_get( 'memory_limit' ),
			'Max Execution Time' => ini_get( 'max_execution_time' ),
			'Upload Max Filesize' => ini_get( 'upload_max_filesize' ),
			'Post Max Size' => ini_get( 'post_max_size' ),
		);
		
		// Get WordPress information
		$wp_info = array(
			'WordPress Version' => $wp_version,
			'Multisite' => is_multisite() ? 'Yes' : 'No',
			'Language' => get_locale(),
			'Timezone' => wp_timezone_string(),
			'Memory Limit' => WP_MEMORY_LIMIT,
		);
		
		// Get theme information
		$theme_info = array(
			'Active Theme' => $active_theme->get( 'Name' ),
			'Theme Version' => $active_theme->get( 'Version' ),
			'Child Theme' => is_child_theme() ? 'Yes' : 'No',
			'Parent Theme' => is_child_theme() ? $active_theme->get( 'Template' ) : 'N/A',
		);
		
		// Get plugin information
		$plugin_info = array(
			'Plugin Name' => $plugin_data['Name'],
			'Plugin Version' => $plugin_data['Version'],
			'Plugin Author' => $plugin_data['Author'],
			'Plugin URI' => $plugin_data['PluginURI'],
		);
		
		// Get active plugins (limited to avoid too much data)
		$active_plugins_list = array();
		foreach ( $active_plugins as $plugin ) {
			$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
			$active_plugins_list[] = $plugin_data['Name'] . ' (' . $plugin_data['Version'] . ')';
		}
		
		// Get recent errors
		$recent_errors = array();
		if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
			$log_file = WP_CONTENT_DIR . '/debug.log';
			if ( file_exists( $log_file ) ) {
				$log_content = file_get_contents( $log_file );
				$log_lines = explode( "\n", $log_content );
				$boorecipe_errors = array_filter( $log_lines, function( $line ) {
					return strpos( $line, 'boo-recipes' ) !== false || strpos( $line, 'boorecipe' ) !== false;
				});
				$recent_errors = array_slice( $boorecipe_errors, -10 ); // Last 10 errors
			}
		}
		
		// Get additional system information
		$additional_info = array();
		
		// Database size
		$db_size = $wpdb->get_var( "SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'DB Size in MB' FROM information_schema.tables WHERE table_schema = '" . DB_NAME . "'" );
		$additional_info['Database Size'] = $db_size ? $db_size . ' MB' : 'Unknown';
		
		// File permissions for uploads directory
		$upload_dir = wp_upload_dir();
		$uploads_path = $upload_dir['basedir'];
		$uploads_writable = is_writable( $uploads_path ) ? 'Yes' : 'No';
		$additional_info['Uploads Directory Writable'] = $uploads_writable;
		
		// Cache status
		$cache_plugins = array();
		if ( is_plugin_active( 'wp-rocket/wp-rocket.php' ) ) $cache_plugins[] = 'WP Rocket';
		if ( is_plugin_active( 'w3-total-cache/w3-total-cache.php' ) ) $cache_plugins[] = 'W3 Total Cache';
		if ( is_plugin_active( 'wp-super-cache/wp-super-cache.php' ) ) $cache_plugins[] = 'WP Super Cache';
		if ( is_plugin_active( 'litespeed-cache/litespeed-cache.php' ) ) $cache_plugins[] = 'LiteSpeed Cache';
		if ( is_plugin_active( 'wp-fastest-cache/wpFastestCache.php' ) ) $cache_plugins[] = 'WP Fastest Cache';
		$additional_info['Active Cache Plugins'] = !empty( $cache_plugins ) ? implode( ', ', $cache_plugins ) : 'None';
		
		// WordPress memory usage
		$wp_memory_usage = function_exists( 'memory_get_usage' ) ? round( memory_get_usage( true ) / 1024 / 1024, 2 ) . ' MB' : 'Unknown';
		$additional_info['Current Memory Usage'] = $wp_memory_usage;
		
		// WordPress debug status
		$wp_debug = defined( 'WP_DEBUG' ) && WP_DEBUG ? 'Yes' : 'No';
		$wp_debug_log = defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ? 'Yes' : 'No';
		$additional_info['WP_DEBUG'] = $wp_debug;
		$additional_info['WP_DEBUG_LOG'] = $wp_debug_log;
		
		// Build the system information text
		$system_info_text = "=== BOO RECIPES SYSTEM INFORMATION ===\n\n";
		
		// Plugin Information
		$system_info_text .= "PLUGIN INFORMATION:\n";
		$system_info_text .= "==================\n";
		foreach ( $plugin_info as $key => $value ) {
			$system_info_text .= $key . ": " . $value . "\n";
		}
		$system_info_text .= "\n";
		
		// WordPress Information
		$system_info_text .= "WORDPRESS INFORMATION:\n";
		$system_info_text .= "=====================\n";
		foreach ( $wp_info as $key => $value ) {
			$system_info_text .= $key . ": " . $value . "\n";
		}
		$system_info_text .= "\n";
		
		// Theme Information
		$system_info_text .= "THEME INFORMATION:\n";
		$system_info_text .= "==================\n";
		foreach ( $theme_info as $key => $value ) {
			$system_info_text .= $key . ": " . $value . "\n";
		}
		$system_info_text .= "\n";
		
		// Server Information
		$system_info_text .= "SERVER INFORMATION:\n";
		$system_info_text .= "==================\n";
		foreach ( $server_info as $key => $value ) {
			$system_info_text .= $key . ": " . $value . "\n";
		}
		$system_info_text .= "\n";
		
		// Active Plugins
		$system_info_text .= "ACTIVE PLUGINS (" . count( $active_plugins_list ) . "):\n";
		$system_info_text .= "==================\n";
		foreach ( $active_plugins_list as $plugin ) {
			$system_info_text .= "- " . $plugin . "\n";
		}
		$system_info_text .= "\n";
		
		// Boo Recipes Settings
		$system_info_text .= "BOO RECIPES SETTINGS:\n";
		$system_info_text .= "====================\n";
		$system_info_text .= print_r( $boorecipe_settings, true );
		$system_info_text .= "\n";
		
		// Additional System Information
		$system_info_text .= "ADDITIONAL SYSTEM INFORMATION:\n";
		$system_info_text .= "==============================\n";
		foreach ( $additional_info as $key => $value ) {
			$system_info_text .= $key . ": " . $value . "\n";
		}
		$system_info_text .= "\n";
		
		// Recent Errors
		if ( ! empty( $recent_errors ) ) {
			$system_info_text .= "RECENT BOO RECIPES ERRORS:\n";
			$system_info_text .= "==========================\n";
			foreach ( $recent_errors as $error ) {
				$system_info_text .= $error . "\n";
			}
			$system_info_text .= "\n";
		}
		
		$system_info_text .= "=== END SYSTEM INFORMATION ===";
		
		return $system_info_text;
	}

	// Backup/restore methods removed

	// Admin footer methods removed - now using proper field integration

	// Old display methods removed - now using proper field integration

	/**
	 *
	 */
	public function admin_convert_settings_handler() {

		// Check Admin referrer
		check_admin_referer( 'convert_existing_settings_using_ajax' );

		// Verify Nonce
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'convert_existing_settings_using_ajax' ) ) {
			wp_send_json_error( __( 'Security token is invalid. Please refresh the page and try again.', 'boo-recipes' ) );
			die();
		}

		// Check capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Sorry, You dont have sufficient permissions to do this action.', 'boo-recipes' ) );
			die();
		}


		// Get old options
		$old_settings = get_option( 'boorecipe-options' );

		// if no old settings found, send error
		if ( ! $old_settings ) {
			wp_send_json_error( __( 'Sorry, We could not find any old settings', 'boo-recipes' ) );
			die();
		}


		$site_lang = mb_substr( get_locale(), 0, 2 );

		if ( ! isset( $old_settings[ $site_lang ] ) ) {
			wp_send_json_error( __( 'Sorry, Settings related to site language is not found. Old settings worked on the basis of site language. We cant do much in this regard. Please contact plugin support to resolve this site-specific issue.', 'boo-recipes' ) );
			die();
		}

		if ( ! is_array( $old_settings[ $site_lang ] ) ) {
			wp_send_json_error( __( 'Sorry, Settings related to site language is not found. Old settings worked on the basis of site language. We cant do much in this regard. Please contact plugin support to resolve this site-specific issue.', 'boo-recipes' ) );
			die();
		}

		$lang_specific_settings = $old_settings[ $site_lang ];
//		$updated_options        = array();
		$count = 0;
		foreach ( $lang_specific_settings as $option_id => $option_value ) {
			update_option( 'boorecipe_' . $option_id, $option_value );
//			$updated_options[ 'boorecipe_' . $option_id ] =  $option_value ;
			$count ++;
		}

		/**
		 * Special cases
		 */
		// default image
		$default_image_path = isset( $lang_specific_settings['recipe_default_img_url'] ) ? $lang_specific_settings['recipe_default_img_url'] : false;
		if ( $default_image_path ) {
			update_option( 'boorecipe_recipe_default_img_url', attachment_url_to_postid( $default_image_path ) );
		}

		// Select Filters to include in Search Form
		$search_filters = isset( $lang_specific_settings['search_form_filters'] ) ? $lang_specific_settings['search_form_filters'] : array();
		if ( is_array( $search_filters ) ) {
			$search_filters_combined = array_combine( $search_filters, $search_filters );
			update_option( 'boorecipe_search_form_filters', $search_filters_combined );
		}

		// Update uninstall settings, change default
		update_option( 'boorecipe_uninstall_delete_options', 'no' );


		/**
		 * END special cases
		 */

		// update for default
		$response = array(
			'success' => true,
			'data'    =>
				sprintf( __( 'Settings have been successfully converted. Total changes made to database are %s.', 'boo-recipes' ), $count ) . " " .
				sprintf( __( 'Page shall reload automatically after %s seconds', 'boo-recipes' ), 10 ),
//			'options' => $updated_options
		);

		// Options Processing Done here
		wp_send_json( json_encode( $response ) );
		wp_die();

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/boorecipe-admin.css', array(), $this->version, 'all' );

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


		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/boorecipe-admin.js',
			array( 'jquery' ),
			$this->version,
			false
		);

		wp_add_inline_script( $this->plugin_name, $this->add_custom_js_in_admin() );


		wp_localize_script( $this->plugin_name, 'wp_ajax', array(
			'ajax_url'                => admin_url( 'admin-ajax.php' ),
			/**
			 * Create nonce for security.
			 *
			 * @link https://codex.wordpress.org/Function_Reference/wp_create_nonce
			 */
			'_nonce_settings_convert' => wp_create_nonce( 'convert_existing_settings_using_ajax' ),
			'_nonce_settings_delete'  => wp_create_nonce( 'delete_existing_settings_using_ajax' ),
		) );

	}

	/**
	 * @hooked admin_footer
	 */
	public function add_custom_js_in_admin() {

		$custom_js = Boorecipe_Globals::get_options_value( 'admin_custom_js_editor' );

		if ( ! $custom_js ) {
			return null;
		}

		return $custom_js;


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
			'page_title'      => __( 'Settings', 'boo-recipes' ),
			// //The Menu Title in Wp Admin
			'menu_title'      => __( 'Settings', 'boo-recipes' ),
			// The capability needed to view the page
			'capability'      => 'manage_options',
			// Slug for the Menu page
			'slug'            => 'boorecipe-settings',
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
				'id'    => 'recipe_single',
				'title' => __( 'Recipe Single', 'boo-recipes' ),
//				'desc'  => 'this is sweet'
			),
			array(
				'id'    => 'recipe_archive',
				'title' => __( 'Recipe Archive', 'boo-recipes' ),
			),
			array(
				'id'    => 'recipe_search_form',
				'title' => __( 'Search Form', 'boo-recipes' ),
			),
			array(
				'id'    => 'recipe_widgets',
				'title' => __( 'Widget Settings', 'boo-recipes' ),
			),
			// Backup/restore tab removed
			'system_info' => array(
				'id'    => 'system_info',
				'title' => __( 'System Information', 'boo-recipes' ),
			),
			array(
				'id'    => 'special_section',
				'title' => __( 'Special', 'boo-recipes' ),
			),
			array(
				'id'    => 'uninstall_section',
				'title' => __( 'Uninstall', 'boo-recipes' ),
			)
		);

		return apply_filters( 'boorecipe_filter_options_sections_array', $sections );
	}

	function get_settings_fields() {
		$options_fields = array();
		/*
		* Recipe Individual
		*/
		$options_fields['recipe_single'] = apply_filters( 'boorecipe_filter_options_fields_array_single', array(

			// === LAYOUT & STYLE ===
			array(
				'id'    => $this->prefix . 'layout_style_heading',
				'type'  => 'html',
				'desc'  => '<h3 style="margin: 20px 0 10px 0; padding: 10px; background: #f1f1f1; border-left: 4px solid #71A866;">Layout & Style</h3>',
			),

			array(
				'id'      => $this->prefix . 'recipe_style',
				'type'    => 'select',
				'label'   => __( 'Recipe Style', 'boo-recipes' ),
				'options' => apply_filters( 'boorecipe_filter_options_fields_array_single_style', array(
					'style1' => sprintf( __( 'Style %s', 'boo-recipes' ), 1 ),
					'style2' => sprintf( __( 'Style %s', 'boo-recipes' ), 2 ),
					'style3' => sprintf( __( 'Style %s', 'boo-recipes' ), 3 ),
					'style4' => sprintf( __( 'Style %s', 'boo-recipes' ), 4 )
				) ),
				'radio'   => true,
				'default' => 'style1',
				'desc'    => __( 'Choose from 4 different recipe layout styles. Note: Image slider does not work with Style 4.', 'boo-recipes' ),
			),

			array(
				'id'      => $this->prefix . 'recipe_layout',
				'type'    => 'select',
				'label'   => __( 'Recipe Layout', 'boo-recipes' ),
				'options' => array(
					'full'  => __( 'Full', 'boo-recipes' ),
					'left'  => __( 'Left', 'boo-recipes' ),
					'right' => __( 'Right', 'boo-recipes' ),
				),
				'radio'   => true,
				'default' => 'full',
			),

			array(
				'id'          => $this->prefix . 'layout_max_width',
				'type'        => 'number',
				'label'       => __( 'Layout Max Width', 'boo-recipes' ),
				'description' => __( 'in pixels', 'boo-recipes' ),
				'default'     => '1048',
				'sanitize'    => 'boorecipe_sanitize_absint',
			),

			array(
				'id'                => $this->prefix . 'ingredient_side',
				'type'              => 'select',
				'label'             => __( 'Ingredients by the Side', 'boo-recipes' ),
				'label_description' => __( 'Do you Want to show ingredients by the side?', 'boo-recipes' ),
				'default'           => 'no',
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),


			array(
				'id'          => $this->prefix . 'color_accent',
				'type'        => 'color',
				'label'       => __( 'Accent Color', 'boo-recipes' ),
				'description' => __( 'This will the theme color for the recipe', 'boo-recipes' ),
				'default'     => '#71A866',
			),

			array(
				'id'          => $this->prefix . 'color_secondary',
				'type'        => 'color',
				'label'       => __( 'Secondary Color', 'boo-recipes' ),
				'description' => __( 'This will be the color for secondary elements (usually in contrast of accent)', 'boo-recipes' ),
				'default'     => '#e8f1e6',
				'rgba'        => true,
			),

			array(
				'id'                => $this->prefix . 'color_icon',
				'type'              => 'color',
				'label'             => __( 'Icon Color', 'boo-recipes' ),
				'label_description' => __( 'This will be the color for icons', 'boo-recipes' ),
				'default'           => '#71A866',
				'rgba'              => true,
			),

			array(
				'id'                => $this->prefix . 'color_border',
				'type'              => 'color',
				'label'             => __( 'Border Color', 'boo-recipes' ),
				'label_description' => __( 'This will be the color for borders in elements', 'boo-recipes' ),
				'default'           => '#e5e5e5',
				'rgba'              => true,
			),

			// === FEATURED IMAGE ===
			array(
				'id'    => $this->prefix . 'featured_image_heading',
				'type'  => 'html',
				'desc'  => '<h3 style="margin: 20px 0 10px 0; padding: 10px; background: #f1f1f1; border-left: 4px solid #71A866;">Featured Image</h3>',
			),

			array(
				'id'                => $this->prefix . 'show_featured_image',
				'type'              => 'select',
				'label'             => __( 'Show Featured Image?', 'boo-recipes' ),
				'label_description' => __( 'Some Themes add this to header, you may want to hide the one added by this plugin to avoid duplicated contents', 'boo-recipes' ),
				'default'           => $this->get_default_options( 'show_featured_image' ),
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'          => $this->prefix . 'featured_image_height',
				'type'        => 'text',
				'label'       => __( 'Featured image height', 'boo-recipes' ),
				'description' => __( 'Maximum height of the recipe image', 'boo-recipes' ),
				'default'     => '576',
				'sanitize'    => 'boorecipe_sanitize_absint',
			),

			array(
				'id'          => $this->prefix . 'recipe_default_img_url',
				'type'        => 'media',
				'label'       => __( 'Recipe default image', 'boo-recipes' ),
				'description' => __( 'Paste the full url to the image you want to use', 'boo-recipes' ),
				'width'       => 768,
				'height'      => 768,
				'max_width'   => 768
			),

			// === NUTRITION INFORMATION ===
			array(
				'id'    => $this->prefix . 'nutrition_heading',
				'type'  => 'html',
				'desc'  => '<h3 style="margin: 20px 0 10px 0; padding: 10px; background: #f1f1f1; border-left: 4px solid #71A866;">Nutrition Information</h3>',
			),

			array(
				'id'                => $this->prefix . 'show_nutrition',
				'type'              => 'select',
				'label'             => __( 'Show Nutrition? (Global)', 'boo-recipes' ),
				'label_description' => __( 'Do you want to show Nutrition info in individual Recipe?', 'boo-recipes' ),
				'default'           => 'yes',
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'                => $this->prefix . 'nutrition_side',
				'type'              => 'select',
				'label'             => __( 'Nutrition by the Side', 'boo-recipes' ),
				'label_description' => __( 'Do you Want to show nutrition by the side?', 'boo-recipes' ),
				'default'           => 'yes',
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'                => $this->prefix . 'hide_empty_nutrition',
				'type'              => 'select',
				'label'             => __( 'Hide Empty Nutrition Info', 'boo-recipes' ),
				'label_description' => __( 'Do you want to hide nutrition info if value not provided?', 'boo-recipes' ),
				'default'           => 'no',
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),



			// === DISPLAY OPTIONS ===
			array(
				'id'    => $this->prefix . 'display_heading',
				'type'  => 'html',
				'desc'  => '<h3 style="margin: 20px 0 10px 0; padding: 10px; background: #f1f1f1; border-left: 4px solid #71A866;">Display Options</h3>',
			),

			array(
				'id'                => $this->prefix . 'show_recipe_title',
				'type'              => 'select',
				'label'             => __( 'Show Recipe Title?', 'boo-recipes' ),
				'label_description' => __( 'Some Themes add this to header, you may want to hide the one added by this plugin to avoid duplicated contents', 'boo-recipes' ),
				'default'           => $this->get_default_options( 'show_recipe_title' ),
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'                => $this->prefix . 'show_recipe_publish_info',
				'type'              => 'select',
				'label'             => __( 'Show Recipe Publish info?', 'boo-recipes' ),
				'label_description' => __( 'Some Themes add this to header, you may want to hide the one added by this plugin to avoid duplicated contents', 'boo-recipes' ),
				'default'           => $this->get_default_options( 'show_recipe_publish_info' ),
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),


			array(
				'id'                => $this->prefix . 'show_published_date',
				'type'              => 'select',
				'label'             => __( 'Show Published Date', 'boo-recipes' ),
				'label_description' => __( 'Do you want to show published date on recipe page?', 'boo-recipes' ),
				'default'           => 'no',
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'                => $this->prefix . 'show_icons',
				'type'              => 'select',
				'label'             => __( 'Show Icons?', 'boo-recipes' ),
				'label_description' => __( 'Do you want to show icons in individual Recipe?', 'boo-recipes' ),
				'default'           => 'yes',
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'                => $this->prefix . 'show_key_point_label',
				'type'              => 'select',
				'label'             => __( 'Show Labels for Key Points?', 'boo-recipes' ),
				'label_description' => __( 'Do you want to show labels for key points in individual Recipe?', 'boo-recipes' ),
				'default'           => 'yes',
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'                => $this->prefix . 'show_share_buttons',
				'type'              => 'select',
				'label'             => __( 'Show Share Buttons?', 'boo-recipes' ),
				'label_description' => __( 'Do you Want to show share buttons on recipe page?', 'boo-recipes' ),
				'default'           => $this->get_default_options( 'show_share_buttons' ),
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'      => $this->prefix . 'show_recipe_tool_img',
				'type'    => 'select',
				'label'   => __( 'Show Recipes tools images', 'boo-recipes' ),
				'default' => $this->get_default_options( 'show_recipe_tool_img' ),
				'options' => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'          => $this->prefix . 'recipe_tool_default_img_url',
				'type'        => 'media',
				'label'       => __( 'Recipe Tool Default image', 'boo-recipes' ),
				'description' => __( 'Select the image you want to use if no recipe tool image found', 'boo-recipes' ),
				'width'       => 150,
				'height'      => 150,
				'max_width'   => 150
			),

			array(
				'id'      => $this->prefix . 'show_cooking_method_img',
				'type'    => 'select',
				'label'   => __( 'Show Cooking method images', 'boo-recipes' ),
				'default' => $this->get_default_options( 'show_cooking_method_img' ),
				'options' => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'          => $this->prefix . 'cooking_method_default_img_url',
				'type'        => 'media',
				'label'       => __( 'Cooking Default image', 'boo-recipes' ),
				'description' => __( 'Select the image you want to use if no recipe tool image found', 'boo-recipes' ),
				'width'       => 150,
				'height'      => 150,
				'max_width'   => 150
			),

			array(
				'id'                => $this->prefix . 'show_author',
				'type'              => 'select',
				'label'             => __( 'Show Author', 'boo-recipes' ),
				'label_description' => __( 'Shows author name with avatar under the recipe title. Note: This only works when "Show Author Box" is set to "No".', 'boo-recipes' ),
				'default'           => 'yes',
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'      => $this->prefix . 'show_author_box',
				'type'    => 'select',
				'label'   => __( 'Show Author Box', 'boo-recipes' ),
				'desc'    => __( 'Shows author in a dedicated box before comments. Note: This will hide the author name under the title. This option will not work with External Author', 'boo-recipes' ),
				'default' => 'no',
				'options' => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'       => $this->prefix . 'author_link_label',
				'type'     => 'text',
				'label'    => __( 'Label for All Recipes By [Author Name]', 'boo-recipes' ),
				'class'    => 'text-class',
				'desc'     => __( 'Enter text if you want to override.', 'boo-recipes' ) . " " .
				              sprintf(
					              __( 'use %s where you want to add author name. Example: All Recipes by %s', 'boo-recipes' ), '<b>%author</b>', '%author' ),
				'sanitize' => 'sanitize_text_field',
			),

			// === ADVANCED SETTINGS ===
			array(
				'id'    => $this->prefix . 'advanced_heading',
				'type'  => 'html',
				'desc'  => '<h3 style="margin: 20px 0 10px 0; padding: 10px; background: #f1f1f1; border-left: 4px solid #71A866;">Advanced Settings</h3>',
			),

			array(
				'id'          => $this->prefix . 'recipe_slug',
				'type'        => 'text',
				'label'       => __( 'Recipe Slug', 'boo-recipes' ),
				'desc'        => sprintf( __( "You will need to re-save %spermalinks%s after changing this value", "boorecipe" ), '<a href=' . get_admin_url() . "options-permalink.php" . ' target="_blank">', '</a>' ),
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

			array(
				'id'      => $this->prefix . 'external_link_type',
				'type'    => 'select',
				'label'   => __( 'External Author Link Type', 'boorecipe-premium' ),
				'default' => 'link_to_name',
				'options' => array(
					'link_to_name'    => esc_html__( 'Link to External Author Name', 'boorecipe-premium' ),
					'show_under_name' => esc_html__( 'Show Under External Author Name', 'boorecipe-premium' )
				),
			),

			array(
				'id'      => $this->prefix . 'ingredients_editor',
				'type'    => 'select',
				'label'   => __( 'Ingredients Editor', 'boo-recipes' ),
				'desc'    => __( 'Choose your preferred ingredients input method', 'boo-recipes' ),
				'default' => 'textarea',
				'options' => apply_filters( 'boorecipe_filter_options_field_ingredients_editor', array(
					'textarea' => __( 'Simple Textarea', 'boo-recipes' ),
					'repeater' => __( 'Repeater Fields', 'boo-recipes' )
				) )
			),

			array(
				'id'      => $this->prefix . 'enable_wysiwyg_editor',
				'type'    => 'select',
				'label'   => __( 'Enable WYSIWYG Editor?', 'boo-recipes' ),
				'options' => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
				'radio'   => true,
				'default' => 'no',
				'desc'    => __( 'This will only be available for Short Description and Additional Notes', 'boo-recipes' ),
			)

		) );
		/*
		 * Recipe Archive
		 */
		$options_fields['recipe_archive'] = apply_filters( 'boorecipe_filter_options_fields_array_archive', array(

			// === LAYOUT & STYLE ===
			array(
				'id'    => $this->prefix . 'archive_layout_heading',
				'type'  => 'html',
				'desc'  => '<h3 style="margin: 20px 0 10px 0; padding: 10px; background: #f1f1f1; border-left: 4px solid #71A866;">Layout & Style</h3>',
			),

			array(
				'id'      => $this->prefix . 'recipe_archive_layout',
				'type'    => 'select',
				'label'   => __( 'Recipes Archive Layout', 'boo-recipes' ),
				'options' => apply_filters( 'boorecipe_filter_options_fields_array_archive_layout', array(
					'grid' => __( 'Grid', 'boo-recipes' ),
					'list' => __( 'List', 'boo-recipes' ),
				) ),
				'default' => $this->get_default_options( 'recipe_archive_layout' ),
			),

			array(
				'id'       => $this->prefix . 'recipes_per_row',
				'type'     => 'select',
				'label'    => __( 'Recipes Per Row', 'boo-recipes' ),
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
				'id'          => 'show_in_masonry',
				'type'        => 'select',
				'label'       => __( 'Show Recipe cards in Masonry?', 'boo-recipes' ),
				'default'     => $this->get_default_options( 'show_in_masonry' ),
				'description' => __( 'If enabled, Layout Switcher will auto disable on front end', 'boo-recipes' ),
				'options'     => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'          => $this->prefix . 'show_layout_switcher',
				'type'        => 'select',
				'label'       => __( 'Show Layout Switcher?', 'boo-recipes' ),
				'description' => __( 'This option only available for List and Grid view', 'boo-recipes' ),
				'default'     => $this->get_default_options( 'show_layout_switcher' ),
				'options'     => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'          => $this->prefix . 'archive_layout_max_width',
				'type'        => 'number',
				'label'       => __( 'Archive Layout Max Width', 'boo-recipes' ),
				'description' => __( 'in pixels', 'boo-recipes' ),
				'default'     => $this->get_default_options( 'archive_layout_max_width' ),
				'sanitize'    => 'boorecipe_sanitize_absint',
			),

			// === COLORS ===
			array(
				'id'    => $this->prefix . 'archive_colors_heading',
				'type'  => 'html',
				'desc'  => '<h3 style="margin: 20px 0 10px 0; padding: 10px; background: #f1f1f1; border-left: 4px solid #71A866;">Colors</h3>',
			),

			array(
				'id'          => $this->prefix . 'color_archive_title',
				'type'        => 'color',
				'label'       => __( 'Recipe Title Color', 'boo-recipes' ),
				'description' => __( 'This will default to theme link color', 'boo-recipes' ),
				'default'     => $this->get_default_options( 'color_archive_title' ),
			),

			array(
				'id'      => $this->prefix . 'color_archive_excerpt',
				'type'    => 'color',
				'label'   => __( 'Recipe Excerpt Color', 'boo-recipes' ),
				'default' => $this->get_default_options( 'color_archive_excerpt' ),
			),

			array(
				'id'      => $this->prefix . 'color_card_bg',
				'type'    => 'color',
				'label'   => __( 'Cards Background Color', 'boo-recipes' ),
				'default' => $this->get_default_options( 'color_card_bg' ),
				'rgba'    => true,
			),

			array(
				'id'      => $this->prefix . 'color_archive_keys',
				'type'    => 'color',
				'label'   => __( 'Key Points Text Color', 'boo-recipes' ),
				'default' => $this->get_default_options( 'color_archive_keys' ),
			),

			array(
				'id'      => $this->prefix . 'color_archive_key_points_bg',
				'type'    => 'color',
				'label'   => __( 'Key Points Background Color', 'boo-recipes' ),
				'default' => $this->get_default_options( 'color_archive_key_points_bg' ),
				'rgba'    => true,
			),

			array(
				'id'      => $this->prefix . 'color_archive_hover_overlay',
				'type'    => 'color',
				'label'   => __( 'Hover Overlay Color', 'boo-recipes' ),
				'default' => $this->get_default_options( 'color_archive_hover_overlay' ),
				'rgba'    => true,
			),

			// === DISPLAY OPTIONS ===
			array(
				'id'    => $this->prefix . 'archive_display_heading',
				'type'  => 'html',
				'desc'  => '<h3 style="margin: 20px 0 10px 0; padding: 10px; background: #f1f1f1; border-left: 4px solid #71A866;">Display Options</h3>',
			),

			array(
				'id'       => $this->prefix . 'recipes_per_page',
				'type'     => 'number',
				'label'    => __( 'Recipes Per Page', 'boo-recipes' ),
				'default'  => $this->get_default_options( 'recipes_per_page' ),
				'sanitize' => 'boorecipe_sanitize_absint',
			),

			array(
				'id'      => $this->prefix . 'heading_for_archive_title',
				'type'    => 'select',
				'label'   => __( 'Heading Tag for Recipes Archive', 'boo-recipes' ),
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
				'id'                => $this->prefix . 'show_archive_excerpt',
				'type'              => 'select',
				'label'             => __( 'Show Archive Excerpt', 'boo-recipes' ),
				'label_description' => __( 'Do you want to show archive excerpt?', 'boo-recipes' ),
				'default'           => $this->get_default_options( 'show_archive_excerpt' ),
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'                => $this->prefix . 'show_search_form',
				'type'              => 'select',
				'label'             => __( 'Show Search Form on archive page?', 'boo-recipes' ),
				'label_description' => __( 'If enabled, Search form will be added to recipes archive page ', 'boo-recipes' ),
				'default'           => $this->get_default_options( 'show_search_form' ),
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'                => $this->prefix . 'override_theme_pagination_style',
				'type'              => 'select',
				'label'             => __( 'Override Pagination Styling?', 'boo-recipes' ),
				'label_description' => __( 'Do you want to override theme styling for pagination?', 'boo-recipes' ),
				'default'           => $this->get_default_options( 'override_theme_pagination_style' ),
				'options'           => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			// === ADVANCED SETTINGS ===
			array(
				'id'    => $this->prefix . 'archive_advanced_heading',
				'type'  => 'html',
				'desc'  => '<h3 style="margin: 20px 0 10px 0; padding: 10px; background: #f1f1f1; border-left: 4px solid #71A866;">Advanced Settings</h3>',
			),

			array(
				'id'      => $this->prefix . 'recipe_category_slug',
				'type'    => 'text',
				'label'   => __( 'Recipe Category Slug', 'boorecipe-premium' ),
				'default' => $this->get_default_options( 'recipe_category_slug' ),
				'desc'    => sprintf( __( "You will need to re-save %spermalinks%s after changing this value", "boorecipe" ), '<a href=' . get_admin_url() . "options-permalink.php" . ' target="_blank">', '</a>' ),
			),

			array(
				'id'      => $this->prefix . 'skill_level_slug',
				'type'    => 'text',
				'label'   => __( 'Skill Level Slug', 'boorecipe-premium' ),
				'default' => $this->get_default_options( 'skill_level_slug' ),
				'desc'    => sprintf( __( "You will need to re-save %spermalinks%s after changing this value", "boorecipe" ), '<a href=' . get_admin_url() . "options-permalink.php" . ' target="_blank">', '</a>' ),
			),

			array(
				'id'      => $this->prefix . 'recipe_tags_slug',
				'type'    => 'text',
				'label'   => __( 'Recipe Category Slug', 'boorecipe-premium' ),
				'default' => $this->get_default_options( 'recipe_tags_slug' ),
				'desc'    => sprintf( __( "You will need to re-save %spermalinks%s after changing this value", "boorecipe" ), '<a href=' . get_admin_url() . "options-permalink.php" . ' target="_blank">', '</a>' ),
			)

		) );
		/*
	 * Search Form
	 */
		$options_fields['recipe_search_form'] = apply_filters( 'boorecipe_filter_options_fields_array_search', array(

			array(
				'id'      => $this->prefix . 'form_bg_color',
				'type'    => 'color',
				'label'   => __( 'Form background Color', 'boo-recipes' ),
				'default' => $this->get_default_options( 'form_bg_color' ),
				'rgba'    => true,
//					'description'   => __('This will default to theme link color','boo-recipes'),
			),

			array(
				'id'      => $this->prefix . 'form_button_bg_color',
				'type'    => 'color',
				'label'   => __( 'Button background color', 'boo-recipes' ),
				'default' => $this->get_default_options( 'form_button_bg_color' ),
				'rgba'    => true,
			),

			array(
				'id'      => $this->prefix . 'form_button_text_color',
				'type'    => 'color',
				'label'   => __( 'Button text color', 'boo-recipes' ),
				'default' => $this->get_default_options( 'form_button_text_color' ),
			),

		) );
		/*
		 * Widget Settings
		 */
		$options_fields['recipe_widgets'] = apply_filters( 'boorecipe_filter_options_fields_array_widgets', array(

			array(
				'id'          => $this->prefix . 'recipe_widget_img_width',
				'type'        => 'number',
				'label'       => __( 'Recipe Widget: Image width', 'boo-recipes' ),
				'after'       => __( "in pixels", "boorecipe" ),
				'description' => __( 'its for widget area', 'boo-recipes' ),
				'default'     => $this->get_default_options( 'recipe_widget_img_width' ),
				'sanitize'    => 'boorecipe_sanitize_absint',

			),

			array(
				'id'      => $this->prefix . 'recipe_widget_bg_color',
				'type'    => 'color',
				'label'   => __( 'Recipe Widget: Background color', 'boo-recipes' ),
				'default' => $this->get_default_options( 'recipe_widget_bg_color' ),
				'rgba'    => true,
			),

		) );
		// Backup/restore functionality removed

		/*
		 * System Information
		 */
		$options_fields['system_info'] = apply_filters( 'boorecipe_filter_options_fields_array_system_info', array(
			array(
				'type'  => 'html',
				'label' => __( 'System Information', 'boo-recipes' ),
				'desc'  => __( 'Select all text (Ctrl+A) and copy (Ctrl+C) to paste into your support ticket for faster assistance.', 'boo-recipes' ),
				'callback' => array( $this, 'render_system_info_field' ),
			),
			array(
				'id'          => $this->prefix . 'enable_debug_logging',
				'type'        => 'select',
				'label'       => __( 'Enable Debug Logging', 'boo-recipes' ),
				'desc'        => __( 'Enable detailed logging for troubleshooting. Only enable when needed for support.', 'boo-recipes' ),
				'options'     => array(
					'no'  => __( 'No', 'boo-recipes' ),
					'yes' => __( 'Yes', 'boo-recipes' ),
				),
				'default'     => 'no',
			),
		) );
		/*
		 * Special
		 */
		$special_section_fields = array(

			array(
				'id'    => $this->prefix . 'custom_css_editor',
				'type'  => 'textarea',
				'label' => __( 'Your Custom CSS', 'boo-recipes' ),
				'desc'  => __( 'Add your custom CSS here', 'boo-recipes' ),
			),

			array(
				'id'    => $this->prefix . 'admin_custom_js_editor',
				'type'  => 'textarea',
				'label' => __( 'Your Custom JS for Admin', 'boo-recipes' ),
				'desc'  => __( 'Add your custom JS here', 'boo-recipes' ),
			),

		);

		if ( boorecipe_is_old_settings_available() ) {

			$special_section_fields[] = array(
				'id'    => $this->prefix . 'settings_converter',
				'type'  => 'html',
				'label' => esc_html__( 'Convert Old Settings', 'boo-recipes' ),
				'desc'  => '<input type="button" name="boorecipes-convert-settings" id="boorecipes-convert-settings" class="button button-secondary" value="' . esc_html__( 'Convert Old Settings', 'boo-recipes' ) . '"><div id="boorecipes-convert-settings-response"></div>'
			);

			$special_section_fields[] = array(
				'id'    => $this->prefix . 'update_recipes_meta',
				'type'  => 'html',
				'label' => __( 'Update Recipes Meta', 'boo-recipes' ),
				'desc'  => sprintf( '<input 
				type="button" 
				class="button button-secondary" 
				value="' . esc_html__( 'Update Recipes Meta', 'boo-recipes' ) . '"
				onclick="window.location.href=\'%s\'"
				>', admin_url( 'edit.php?post_type=boo_recipe&page=boorecipe-update-meta' ) )
			);
//			' . . '

			$special_section_fields[] = array(
				'id'    => $this->prefix . 'settings_delete_old',
				'type'  => 'html',
				'label' => __( 'Delete Old Settings', 'boo-recipes' ),
				'desc'  => '<input type="button" name="boorecipes-delete-old-settings" id="boorecipes-delete-old-settings" class="button button-secondary" value="' . esc_html__( 'Delete Old Settings', 'boo-recipes' ) . '"><div id="boorecipes-delete-old-settings-response"></div>'
			);
		}


		$options_fields['special_section'] = apply_filters( 'boorecipe_filter_options_fields_array_special', $special_section_fields );

		/*
		 * Uninstall
		 */
		$options_fields['uninstall_section'] = apply_filters( 'boorecipe_filter_options_fields_array_uninstall', array(

			array(
				'id'          => $this->prefix . 'uninstall_delete_options',
				'type'        => 'select',
				'label'       => __( 'Delete Plugin Options', 'boo-recipes' ),
				'description' => __( 'Delete all plugin options data at uninstall?', 'boo-recipes' ),
				'help'        => __( 'green = Yes & red = No', 'boo-recipes' ),
				'default'     => $this->get_default_options( 'uninstall_delete_options' ),
				'options'     => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),

			array(
				'id'          => $this->prefix . 'uninstall_delete_meta',
				'type'        => 'select',
				'label'       => __( 'Delete Recipes Data', 'boo-recipes' ),
				'description' => __( 'Delete all recipes meta data at uninstall?', 'boo-recipes' ),
				'help'        => __( 'green = Yes & red = No', 'boo-recipes' ),
				'default'     => $this->get_default_options( 'uninstall_delete_mata' ),
				'options'     => array(
					'yes' => esc_html__( 'Yes', 'boo-recipes' ),
					'no'  => esc_html__( 'No', 'boo-recipes' )
				),
			),


		) );

		return apply_filters( 'boorecipe_filter_options_fields_array', $options_fields );
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
			'name'        => __( 'Recipe Single Sidebar', 'boo-recipes' ),
			'id'          => 'recipe-single-sidebar',
			'description' => __( 'Widgets in this area will be shown on Single Recipe', 'boo-recipes' ),
		) );

		// Archive Recipe Sidebar
		register_sidebar( array(
			'name'        => __( 'Recipe Archive Sidebar', 'boo-recipes' ),
			'id'          => 'recipe-archive-sidebar',
			'description' => __( 'Widgets in this area will be shown on Recipe Archive pages', 'boo-recipes' ),
		) );

	}


}
