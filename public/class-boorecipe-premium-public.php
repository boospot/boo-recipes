<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Premium_Public' ) ) {
	return;
}

// Require the class file from parent plugin as the premium class is extending that class
// For unified plugin, the parent class is in the same plugin
require_once BOORECIPE_BASE_DIR . 'public/class-boorecipe-public.php';

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Boorecipe_Premium
 * @subpackage Boorecipe_Premium/public
 * @author     Rao Abid <raoabid491@gmail.com>
 */
class Boorecipe_Premium_Public extends Boorecipe_Public {

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
		 * defined in Boorecipe_Premium_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Boorecipe_Premium_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

//		rao_var_dump( $this->plugin_name);

		wp_register_style( $this->plugin_name . '-premium-single', plugin_dir_url( __FILE__ ) . 'css/boorecipe-premium-single.css', array(), $this->version, 'all' );


		wp_register_style( $this->plugin_name . "-flexslider", plugin_dir_url( __FILE__ ) . 'css/lib/flexslider.css', array(), $this->version, 'screen' );


		if ( is_singular( 'boo_recipe' ) || boorecipe_is_active_shortcode_single() ) {

			wp_enqueue_style( $this->plugin_name . "-flexslider" );

			wp_enqueue_style( $this->plugin_name . '-premium-single' );

		}


	}

	/**
	 * dequeue styles( of base plugin
	 *
	 * @since    1.0.0
	 */
	public function dequeue_styles() {

		// dequeue style of base plugin
		wp_dequeue_style( $this->plugin_name . "-single" );


	}


	/**
	 * dequeue scripts of base plugin
	 *
	 * @since    1.0.0
	 */
	public function dequeue_scripts() {

		// dequeue style of base plugin
		wp_dequeue_script( $this->plugin_name );


	}

	/**
	 * Get options from Boorecipe_Globals
	 *
	 * @param string $option_id
	 *
	 * @return mixed options value
	 * @since    1.0.0
	 *
	 */
	public function get_options_value( $option_id ) {

		return Boorecipe_Globals::get_options_value( $option_id );
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
		 * defined in Boorecipe_Premium_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Boorecipe_Premium_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_script( $this->plugin_name . '-flexslider', plugin_dir_url( __FILE__ ) . 'js/lib/jquery.flexslider-min.js', array( 'jquery' ), $this->version, true );

		wp_register_script( $this->plugin_name . '-premium', plugin_dir_url( __FILE__ ) . 'js/boorecipe-premium-public.js', array( 'jquery' ), $this->version, true );


		if ( is_singular( 'boo_recipe' ) || boorecipe_is_active_shortcode_single() ) {


			if ( $this->is_show_image_slider_active() ) {
				wp_enqueue_script( $this->plugin_name . '-flexslider' );
			}


			wp_enqueue_script( $this->plugin_name . '-premium' );

		}


	}

	public function is_show_image_slider_active() {

		$meta = Boorecipe_Globals::get_recipe_meta( get_the_ID() );


		if ( isset( $meta['show_image_slider'] ) && ( $meta['show_image_slider'] == 1 || 'yes' === $meta['show_image_slider'] ) ) {
			return true;
		} else {
			return false;
		}


	}

	public function is_recipe_has_attached_images() {

		if ( ! $this->is_single_recipe() ) {
			return false;
		}

		$attached_media = get_attached_media( 'image', get_the_ID() );

		return ( ! empty( $attached_media ) ) ? true : false;
	}

	public function is_single_recipe() {
		return ( is_singular( 'boo_recipe' ) ) ? true : false;
	}


}

