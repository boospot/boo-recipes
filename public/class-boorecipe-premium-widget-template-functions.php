<?php
/** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection PhpUnusedParameterInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Premium_Widget_Template_Functions' ) ) {
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
 */

// Require the class file from parent plugin as the premium class is extending that class
require_once BOORECIPE_BASE_DIR . 'public/class-boorecipe-widget-template-functions.php';

/**
 * For Premium Single Template Functions
 * Class Boorecipe_Premium_Single_Template_Functions
 */
class Boorecipe_Premium_Widget_Template_Functions extends Boorecipe_Widget_Template_Functions {


	/**
	 * Include      public/templates/single/search-form-fields-select
	 *
	 * @hooked      boorecipe_widget_search_form_fields        7
	 *
	 */
	public function search_form_cuisine_field() {
		$field_args = array(
			'type'         => 'taxonomy',
			'id'           => 'recipe_cuisine',
			'blank_option' => 'any'
		);

		if ( ! $this->is_show_search_form_field( $field_args['id'] ) ) {
			return;
		}

		include boorecipe_get_template( 'search-form-fields-select', 'widgets' );

	}

} // class