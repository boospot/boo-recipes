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
class Boorecipe_Admin_Ajax_Meta_Update {

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


	private $settings_api;


	private $recipe_query;

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
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );


	}


	function admin_menu() {


		$config_array = array(
			'options_id' => 'boorecipe_meta_update',
			'tabs'       => false,
			'menu'       => $this->get_settings_menu(),
			'sections'   => $this->get_settings_sections(),
			'fields'     => $this->get_settings_fields(),
			'form'       => array(
				'submit_label' => 'Update Meta',
//				'id' => 'ajax-update',
//				'class' => 'ajax-update-class'
			)
		);


		$this->settings_api = new Boo_Settings_Helper( $config_array );

		//set menu settings
//			$this->settings_api->set_menu( $this->get_settings_menu() );


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
			'page_title' => __( 'Update Recipes Meta', 'boorecipe' ),
			// //The Menu Title in Wp Admin
			'menu_title' => __( 'Update Recipes Meta', 'boorecipe' ),
			// The capability needed to view the page
			'capability' => 'manage_options',
			// Slug for the Menu page
			'slug'       => 'boorecipe-update-meta',
			// dashicons id or url to icon
			// https://developer.wordpress.org/resource/dashicons/
			'icon'       => 'dashicons-performance',
			// Required for submenu
			'submenu'    => true,
			// position
			'position'   => 10,
			// For sub menu, we can define parent menu slug (Defaults to Options Page)
			'parent'     => 'edit.php?post_type=boo_recipe',
		);

		return $config_menu;
	}

	function get_settings_sections() {

		$sections = array();

		$sections[] = array(
			'id'    => 'update_meta_help',
			'title' => __( 'Why Update Meta', 'boorecipe' ),
			'desc'  => __( 'You need to update recipes if you have updated from version 1.0.1. We have changed recipe meta storage mechanism for optimization. If your recipes are not showing properly, you need to select the recipes below and click the [Update Now] button. It is strongly recommended you take backup of your existing database in case you need to restore it if something does not work as expected.', 'boorecipe' ),
		);

		$query = $this->get_recipes_query();

		if ( $query->post_count > 0 ) {

			$sections[] = array(
				'id'    => 'update_meta',
				'title' => __( 'Update Recipes Meta', 'boorecipe' ),
				'desc'  => __( 'List of Recipes requiring update', 'boorecipe' ),
			);

		} else {
			$sections[] = array(
				'id'    => 'no_recipes_to_update',
				'title' => __( 'Congratulations', 'boorecipe' ),
				'desc'  => '<div>All your Recipes are updated. You dont need to do anything for recipes meta update.</div>'
			);


		}


		return $sections;
	}

	public function get_recipes_query() {


		if ( empty( $this->recipe_query ) ) {

			$this->recipe_query = new WP_Query( array(
				'post_type'      => 'boo_recipe',
				'posts_per_page' => - 1,
				'meta_query'     => array(
					'relation' => 'OR',
					array(
						'key'     => 'boorecipe_meta_updated',
						'compare' => 'NOT EXISTS', // works!
						'value'   => '' // This is ignored, but is necessary...
					),
					array(
						'key'   => 'boorecipe_meta_updated',
						'value' => 'anything'
					)
				)
			) );

		}

		return $this->recipe_query;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {

//		var_dump( array_keys( $this->get_recipes() ) );
//		die();


		$update_meta_fields             = array(
//				array(
//					'name'  => 'ajax_trigger',
//					'desc'  => __( '<a class="update_recipe_meta" href="#">Update Recipe Meta</a>', 'boorecipe' ),
//					'label' => __( 'Click the Button', 'boorecipe' ),
//					'type'  => 'html'
//				),

			array(
				'name'    => 'recipes',
				'label'   => __( 'Recipes', 'boorecipe' ),
				'type'    => 'multicheck',
				'default' => $this->get_recipes_checkbox_default(),
				'options' => $this->get_recipes()
			),

			array(
				'name' => 'html',
				'desc' => __( '<style>
							.ajax-form-wrap { width: 100%; overflow: hidden; margin: 0 0 20px 0; }
							.ajax-form { float: left; width: 400px; }
							.examples  { float: left; width: 200px; }
							.ajax-response div {
								width: 95%; overflow: auto; margin: 20px 0; padding: 10px 20px;
								color: #fff;
							}
							.ajax-response div.recipe-already-updated {
								background-color: orange;
							}
							.ajax-response div.recipe-update-fail {
								background-color: red;
							}
							.ajax-response div.recipe-update-success {
								background-color: green;
							}
							 
							</style>
							<div class="ajax-response"></div>' ),
//					'label' => __( 'Click the Button', 'boorecipe' ),
				'type' => 'html'
			),


		);
		$settings_fields                = array();
		$settings_fields['update_meta'] = $update_meta_fields;


		return $settings_fields;
	}

	public function get_recipes_checkbox_default() {

		$default = array();

		$recipes = $this->get_recipes();

		foreach ( $recipes as $key => $value ) {
			$default[ $key ] = $key;

		}
		unset( $recipes );

		return $default;

	}

	public function get_recipes() {


		$recipes = array();

		$query = $this->get_recipes_query();

		$posts = $query->posts;


		foreach ( $posts as $recipe ) {
			$recipes[ $recipe->ID ] = $recipe->post_title;
		}

		unset( $query, $posts );

//		var_dump( $recipes); die();


		return $recipes;

	}

	public function ajax_admin_enqueue_scripts( $hook ) {

		// check if our page
		if ( 'boo_recipe_page_boorecipe-update-meta' !== $hook ) {
			return;
		}


		wp_enqueue_script( $this->plugin_name . '-ajax-admin', plugin_dir_url( __FILE__ ) . 'js/ajax-admin.js', array( 'jquery' ), $this->version );


		// create nonce
		$nonce = wp_create_nonce( 'ajax_admin' );

		// define script
		$script = array( 'nonce' => $nonce );

		// localize script
		wp_localize_script( $this->plugin_name . '-ajax-admin', 'ajax_admin', $script );


//		var_dump( $this->is_update_required( 954 )); die();

	}


	// process ajax request

	public function ajax_admin_handler() {

		// check nonce
		check_ajax_referer( 'ajax_admin', 'nonce' );

		// check user
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}


		/**
		 * Do your magic here
		 */
		$response = array();

//			$params = array();
//			parse_str($_POST['data'], $params);


//			$params = array();
//			parse_str($_POST['id'], $params);

//			var_dump( $_POST['id']);

		$post_id = absint( $_POST['id'] );

		$post = get_post( $post_id );

		$is_update_required = $this->is_update_required( $post_id );

		if ( $is_update_required ) {

			$try_to_update = $this->update_post_meta( $post_id );

			if ( $try_to_update ) {

				$response['status'] = 'success';


			} else {
				$response['status'] = 'fail';
			}


		} else {

			$response['status'] = 'already_updated';

		}


		$response['post']['id']    = $post->ID;
		$response['post']['title'] = $post->post_title;


		echo json_encode( $response );
//			echo 'No results. Please check the URL and try again.';


		/**
		 * End your magic here
		 */


		// end processing
		wp_die();

	}

	private function is_update_required( $post_id ) {


		$existing_meta = get_post_meta( $post_id, 'boorecipe_meta_updated', true );

		return ( $existing_meta == true ) ? false : true;

	}

	private function update_post_meta( $post_id ) {

		$prefix = Boorecipe_Globals::get_meta_prefix();

		$existing_meta = get_post_meta( $post_id, 'boorecipe-recipe-meta', true );

		foreach ( $existing_meta as $meta_key => $meta_value ) {

			$prev_value = get_post_meta( $post_id, $prefix . $meta_key, true );

			if ( $prev_value == $meta_value ) {
				continue;
			}
			$updated = update_post_meta( $post_id, $prefix . $meta_key, $meta_value );

			if ( $updated == false ) {
				return false;
			}

		}
		$updated = delete_post_meta( $post_id, 'boorecipe-recipe-meta' );
		$updated = update_post_meta( $post_id, 'boorecipe_meta_updated', true );

		return ( $updated != false ) ? true : false;

	}


}
