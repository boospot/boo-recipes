<?php
/** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection PhpUnusedParameterInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// if class already defined, bail out
if ( class_exists( 'Boorecipe_Widget_Template_Functions' ) ) {
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
class Boorecipe_Widget_Template_Functions extends Boorecipe_Template_Functions {


	/**
	 * Include      public/templates/single/search-form-fields-select
	 *
	 * @hooked      boorecipe_widget_search_form_fields        7
	 *
	 */
	public function search_form_category_field() {

		$field_args = array(
			'type'         => 'taxonomy',
			'id'           => 'recipe_category',
			'blank_option' => 'any'
		);

		if ( ! $this->is_show_search_form_field( $field_args['id'] ) ) {
			return;
		}

		include boorecipe_get_template( 'search-form-fields-select', 'widgets' );

	} // search_form_category_field

	/**
	 * @param $field_id
	 *
	 * @return bool
	 */
	public function is_show_search_form_field( $field_id ) {
		// Check if premium option is active and have value
		if ( ! is_array( $this->get_options_value( 'search_form_filters' ) ) ) {
			// Return tru if this option is not set, meaning that premium plugin is not installed,
			// so we return true in every case
			return true;
		}

		return in_array( $field_id, $this->get_options_value( 'search_form_filters' ) );

	}

	/**
	 * Include      public/templates/single/search-form-fields-select
	 *
	 * @hooked      boorecipe_widget_search_form_fields        9
	 */
	public function search_form_skill_level_field() {

		$field_args = array(
			'type'         => 'taxonomy',
			'label_key'    => 'skill_level',
			'id'           => 'skill_level',
			'blank_option' => 'any'
		);

		if ( ! $this->is_show_search_form_field( $field_args['id'] ) ) {
			return;
		}

		include boorecipe_get_template( 'search-form-fields-select', 'widgets' );

	}

	/**
	 * Include      public/templates/single/search-form-fields-text
	 *
	 * @hooked      boorecipe_widget_search_form_fields        9
	 */
	public function search_form_keyword_field() {

		$field_args = array(
			'type'        => 'meta',
			'label_key'   => 'keyword',
			'id'          => 'keyword',
			'placeholder' => boorecipe_get_default_options( 'message_placeholder_keyword_field' ),
		);

		if ( ! $this->is_show_search_form_field( $field_args['id'] ) ) {
			return;
		}

		include boorecipe_get_template( 'search-form-fields-text', 'widgets' );

	}

} // class