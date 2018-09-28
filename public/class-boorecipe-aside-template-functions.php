<?php
/** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection PhpUnusedParameterInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Aside_Template_Functions' ) ) {
	return;
}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the methods for creating the templates.
 *
 * @package    Boorecipe
 * @subpackage Boorecipe/public
 *
 *
 */
class Boorecipe_Aside_Template_Functions extends Boorecipe_Template_Functions {

	/**
	 * Include      public/templates/aside/sidebar-recipe-single
	 *
	 * @hooked       boorecipe_recipe_single_aside        11
	 *
	 * @param        object $item A post object
	 * @param        array $meta The post metadata
	 *
	 */
	public function aside_recipe_single( $item, $meta ) {
		if ( $this->get_sidebar_layout() ) {
			include boorecipe_get_template( 'sidebar-recipe-single', 'aside' );
		}
	}


	/**
	 * Filter sidebar classes
	 *
	 * @param array $classes_array
	 *
	 * @return array $classes_array
	 */
	public function filter_aside_single_recipe_classes( $classes_array ) {

		if ( $this->get_sidebar_layout() ) {
			$classes_array[] = 'sidebar-' . $this->get_sidebar_layout();
		}

		return $classes_array;
	}



} // class