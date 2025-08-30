<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Premium_Template_Functions' ) ) {
	return;
}


// Require the class file from parent plugin as the premium class is extending that class
// For unified plugin, the parent class is in the same plugin
require_once BOORECIPE_BASE_DIR . 'public/class-boorecipe-template-functions.php';

class Boorecipe_Premium_Template_Functions extends Boorecipe_Template_Functions {

	/*
	 * Add Premium Plugin templates directory to template paths
	 *
	 * @return string|array
	 *
	 * @string template path if success
	 * @array   $args_array is failure
	 *
	 */
	public function add_template_path( $args_array ) {

		$name               = ( isset( $args_array['name'] ) ) ? ( $args_array['name'] ) : false;
		$sub_directory_path = ( isset( $args_array['sub_directory_path'] ) ) ? ( $args_array['sub_directory_path'] ) : '';

		if ( ! $name || ! $sub_directory_path ) {
			return $name;
		}

		// For unified plugin, use the same base directory
		$template = BOORECIPE_BASE_DIR . "public/templates/$sub_directory_path" . $name . '.php';

		if ( ! is_file( $template ) ) {
			return $args_array;
		}


		return $template;
	}


} // class

