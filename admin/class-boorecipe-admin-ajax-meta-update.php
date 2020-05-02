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
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 *
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
			)
		);


		$this->settings_api = new Boo_Settings_Helper( $config_array );

		//initialize settings
		$this->settings_api->admin_init();


	}

	function get_settings_menu() {
		$config_menu = array(
			//The name of this page
			'page_title' => __( 'Update Recipes Meta', 'boo-recipes' ),
			// //The Menu Title in Wp Admin
			'menu_title' => __( 'Update Recipes Meta', 'boo-recipes' ),
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
			'title' => __( 'Why Update Meta', 'boo-recipes' ),
			'desc'  => __( 'You need to update recipes that are using image sliders. No Need to update if slider is working fine after update. Its only required in some special cases.', 'boo-recipes' ),
		);

		$query = $this->get_recipes_query();

		if ( $query->post_count > 0 ) {

			$sections[] = array(
				'id'    => 'update_meta',
				'title' => __( 'Update Recipes Meta', 'boo-recipes' ),
				'desc'  => __( 'List of Recipes requiring update', 'boo-recipes' ),
			);

		} else {
			$sections[] = array(
				'id'    => 'no_recipes_to_update',
				'title' => __( 'Congratulations', 'boo-recipes' ),
				'desc'  => __( 'All your Recipes are updated. You dont need to do anything for recipes meta update.', 'boo-recipes' )
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
					'relation' => 'AND',

					array(
						'relation' => 'OR',
						array(
							'key'     => 'boorecipe_show_image_slider',
							'value'   => 1,
							'compare' => '='
						),
						array(
							'key'   => 'boorecipe_show_image_slider',
							'value' => 'yes'
						),
					),

					array(
						'key'     => 'boorecipe_recipe_image_slider_items_attached',
//						'value'   => true,
						'compare' => 'NOT EXISTS'
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


		$update_meta_fields             = array(

			array(
				'id'      => 'recipes',
				'label'   => __( 'Recipes', 'boo-recipes' ),
				'type'    => 'multicheck',
				'default' => $this->get_recipes_checkbox_default(),
				'options' => $this->get_recipes()
			),

			array(
				'id'   => 'html',
				'desc' => __( '<style>
							.ajax-form-wrap { width: 100%; overflow: hidden; margin: 0 0 20px 0; }
							.ajax-form { float: left; width: 400px; }
							.examples  { float: left; width: 200px; }
							.ajax-response div, .admin-instruction-for-update {
								width: 95%; overflow: auto; margin: 20px 0; padding: 10px 20px;
								color: #fff;
							}
							.ajax-response div.recipe-already-updated {
								background-color: orange;
							}
							.ajax-response div.recipe-update-fail, .admin-instruction-for-update {
								background-color: red;
							}
							.ajax-response div.recipe-update-success {
								background-color: green;
							}
							 
							</style>
							<div class="admin-instruction-for-update recipe-update-fail"><strong>DO NOT RELOAD</strong> this page after clicking the button, Page will refresh Automatically once process is complete</div>
							<div class="ajax-response"></div>' ),
//					'label' => __( 'Click the Button', 'boo-recipes' ),
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

		return $recipes;

	}

	public function ajax_admin_enqueue_scripts( $hook ) {

//		var_dump_pretty( $hook);
//		die();

//		 check if our page
		if ( 'boo_recipe_page_boorecipe-update-meta' !== $hook ) {
			return;
		}


		wp_enqueue_script( $this->plugin_name . '-ajax-admin', plugin_dir_url( __FILE__ ) . 'js/ajax-admin.js', array( 'jquery' ), $this->version );


		// create nonce
		$nonce = wp_create_nonce( 'update_recipe_meta' );

		// define script
		$script = array( 'nonce' => $nonce );

		// localize script
		wp_localize_script( $this->plugin_name . '-ajax-admin', 'ajax_admin', $script );

	}


	// process ajax request

	public function ajax_admin_handler() {

		// check nonce
		check_ajax_referer( 'update_recipe_meta', 'nonce' );

		// check user
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}


		/**
		 * Do your magic here
		 */
		$response = array();

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

		wp_send_json( json_encode( $response ) );

		/**
		 * End your magic here
		 */

		// end processing
		wp_die();

	}

	private function is_update_required( $post_id ) {

		$existing_meta = get_post_meta( $post_id, 'boorecipe_recipe_image_slider_items_attached' );

		return ( ! $existing_meta ) ? true : false;

	}

	private function update_post_meta( $post_id ) {
		// Start : Recipe post metadata conversion
		$updated = false;

		$images = get_attached_media( 'image', $post_id );

		if ( count( $images ) > 1 ) {
			foreach ( $images as $image_id => $image_object ) {
				$attached_images = get_post_meta( $post_id, 'boorecipe_recipe_image_slider_items_attached' );
				if ( ! in_array( $image_id, $attached_images ) ) {
					$updated = add_post_meta( $post_id, 'boorecipe_recipe_image_slider_items_attached', $image_id );
				}
			}
		}

		return ( $updated != false ) ? true : false;

	}


}
