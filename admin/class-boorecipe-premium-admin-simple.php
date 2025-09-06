<?php /** @noinspection PhpIncludeInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Premium_Admin_Simple' ) ) {
	return;
}

if ( ! file_exists( BOORECIPE_BASE_DIR . 'admin/class-boorecipe-admin-simple.php' ) ) {
	return;
}

// Require the class file from parent plugin as the premium class is extending that class
require_once BOORECIPE_BASE_DIR . 'admin/class-boorecipe-admin-simple.php';

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/raoabid
 * @since      1.0.0
 *
 * @package    Boorecipe_Premium
 * @subpackage Boorecipe_Premium/admin
 */
class Boorecipe_Premium_Admin_Simple extends Boorecipe_Admin_Simple {

	/**
	 * @param $sections_array
	 *
	 * @return array
	 */
	public function filter_options_sections_array( array $sections_array ) {
		/*
		 * Labels
		 */
		$position_of_labels_section = 4;
		$labels_section             = array(
			array(
				'id'    => 'fields_labels',
				'title' => __( 'Labels', 'boo-recipes' ),
			)
		);
		array_splice( $sections_array, $position_of_labels_section, 0, $labels_section );

		/*
		 * Hooks
		 */
		$position_of_action_hooks_section = 5;

		$hooks_section = array(
			array(
				'id'    => 'recipe_action_hooks',
				'title' => __( 'Insertion Points', 'boo-recipes' ),
				'desc'  => __( 'Anything you put in these settings will appear as per insertion point specified . Shortcodes also allowed.', 'boo-recipes' ),
			)
		);

		array_splice( $sections_array, $position_of_action_hooks_section, 0, $hooks_section );

		/*
		 * System Information
		 */
		if ( isset( $sections_array['system_info'] ) && is_array( $sections_array['system_info'] ) ):

			$sections_array['system_info']['title'] = __( 'System Information', 'boo-recipes' );

		endif;

		return $sections_array;

	}

	/**
	 * @hooked      boorecipe_options_args_array        10
	 *
	 * @param array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	public function filter_options_fields_array( $options_fields ) {

		$options_fields['fields_labels'] = apply_filters( 'boorecipe_options_fields_labels', array(

			array(
				'id'          => $this->prefix . 'recipe_category_label',
				'type'        => 'text',
				'label'       => __( 'Category Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'placeholder' => $this->get_default_options( 'recipe_category_label' ),
				'sanitize'    => 'sanitize_text_field',

			),

			array(
				'id'          => $this->prefix . 'recipe_cuisine_label',
				'type'        => 'text',
				'label'       => __( 'Cuisine Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'placeholder' => $this->get_default_options( 'recipe_cuisine_label' ),
				'sanitize'    => 'sanitize_text_field',

			),

			array(
				'id'          => $this->prefix . 'skill_level_label',
				'type'        => 'text',
				'label'       => __( 'Skill Level Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'skill_level_label' ),
			),

			array(
				'id'          => $this->prefix . 'cooking_method_label',
				'type'        => 'text',
				'label'       => __( 'Cooking Method Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'recipe_tags_label' ),
			),

			array(
				'id'          => $this->prefix . 'recipe_tags_label',
				'type'        => 'text',
				'label'       => __( 'Tags Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'recipe_tags_label' ),
			),


			array(
				'id'          => $this->prefix . 'prep_time_label',
				'type'        => 'text',
				'label'       => __( 'Prep Time Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'prep_time_label' ),

			),

			array(
				'id'          => $this->prefix . 'cook_time_label',
				'type'        => 'text',
				'label'       => __( 'Cook Time Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'cook_time_label' ),
			),

			array(
				'id'          => $this->prefix . 'total_time_label',
				'type'        => 'text',
				'label'       => __( 'Total Time Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'total_time_label' ),
			),

			array(
				'id'          => $this->prefix . 'time_unit_minutes_label',
				'type'        => 'text',
				'label'       => __( 'Minutes (time unit) Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'time_unit_minutes_label' ),
			),

			array(
				'id'          => $this->prefix . 'time_unit_hours_label',
				'type'        => 'text',
				'label'       => __( 'Hours (time unit) Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'time_unit_hours_label' ),
			),

			array(
				'id'          => $this->prefix . 'yields_label',
				'type'        => 'text',
				'label'       => __( 'Yields Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'yields_label' ),
			),

			array(
				'id'          => $this->prefix . 'keyword_label',
				'type'        => 'text',
				'label'       => __( 'Keywords Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'keyword_label' ),

			),


			array(
				'id'          => $this->prefix . 'ingredients_label',
				'type'        => 'text',
				'label'       => __( 'Ingredients Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'ingredients_label' ),
			),

			array(
				'id'          => $this->prefix . 'directions_label',
				'type'        => 'text',
				'label'       => __( 'Directions Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'directions_label' ),
			),

			array(
				'id'          => $this->prefix . 'nutrition_label',
				'type'        => 'text',
				'label'       => __( 'Nutrition Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'nutrition_label' ),
			),

			array(
				'id'          => $this->prefix . 'nutrition_facts_label',
				'type'        => 'text',
				'label'       => __( 'Nutrition Facts Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'nutrition_facts_label' ),
			),

			array(
				'id'          => $this->prefix . 'recipe_ratings_label',
				'type'        => 'text',
				'label'       => __( 'Ratings Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'recipe_ratings_label' ),
			),

			array(
				'id'          => $this->prefix . 'rating_start_label',
				'type'        => 'text',
				'label'       => __( 'Ratings string start with', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'rating_start_label' ),
			),

			array(
				'id'          => $this->prefix . 'rating_based_on_label',
				'type'        => 'text',
				'label'       => __( 'Ratings string "based on"', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'rating_based_on_label' ),
			),

			array(
				'id'          => $this->prefix . 'rating_customer_reviews_label',
				'type'        => 'text',
				'label'       => __( 'Ratings string ends', 'boo-recipes' ),
				'class'       => 'text-class',
				'placeholder' => $this->get_default_options( 'rating_customer_reviews_label' ),
				'sanitize'    => 'sanitize_text_field',
			),

			array(
				'id'          => $this->prefix . 'related_recipes_label',
				'type'        => 'text',
				'label'       => __( 'Related Recipes Label', 'boo-recipes' ),
				'dependency'  => array( 'related_recipes_show', '==', 'true' ),
				'placeholder' => $this->get_default_options( 'related_recipes_label' ),
				'sanitize'    => 'sanitize_text_field',
			),

			array(
				'id'          => $this->prefix . 'recipe_tool_label',
				'type'        => 'text',
				'label'       => __( 'Recipe Tools Label', 'boo-recipes' ),
				'dependency'  => array( 'related_recipes_show', '==', 'true' ),
				'placeholder' => $this->get_default_options( 'recipe_tool_label' ),
				'sanitize'    => 'sanitize_text_field',
			),

			array(
				'id'          => $this->prefix . 'additional_notes_label',
				'type'        => 'text',
				'label'       => __( 'Additional Notes Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'sanitize'    => 'sanitize_text_field',
				'placeholder' => $this->get_default_options( 'additional_notes_label' ),
			),

			array(
				'id'          => $this->prefix . 'submit_button_label',
				'type'        => 'text',
				'label'       => __( 'Submit Button Label', 'boo-recipes' ),
				'class'       => 'text-class',
				'placeholder' => $this->get_default_options( 'submit_button_label' ),
				'sanitize'    => 'sanitize_text_field',

			),


		) );

		$options_fields['recipe_action_hooks'] = apply_filters( 'boorecipe_options_fields_action_hooks', array(


			array(
				'id'       => $this->prefix . 'single_media_before',
				'type'     => 'textarea',
				'label'    => __( 'Before Recipe Media', 'boo-recipes' ),
				'desc'     => sprintf(
					__( 'You may also use action hook %s', 'boo-recipes' ),
					"<code>boorecipe_single_media_before</code>"
				),
				'sanitize' => 'wp_kses_post',
			),

			array(
				'id'       => $this->prefix . 'single_media_after',
				'type'     => 'textarea',
				'label'    => __( 'After Recipe Media', 'boo-recipes' ),
				'desc'     => sprintf(
					__( 'You may also use action hook %s', 'boo-recipes' ),
					"<code>boorecipe_single_media_after</code>"
				),
				'sanitize' => 'wp_kses_post',
			),

			array(
				'id'       => $this->prefix . 'single_head_before',
				'type'     => 'textarea',
				'label'    => __( 'Before Recipe Head', 'boo-recipes' ),
				'desc'     => sprintf(
					__( 'You may also use action hook %s', 'boo-recipes' ),
					"<code>boorecipe_single_head_before</code>"
				),
				'sanitize' => 'wp_kses_post',
			),

			array(
				'id'       => $this->prefix . 'single_head_after',
				'type'     => 'textarea',
				'label'    => __( 'After Recipe Head', 'boo-recipes' ),
				'desc'     => sprintf(
					__( 'You may also use action hook %s', 'boo-recipes' ),
					"<code>boorecipe_single_head_after</code>"
				),
				'sanitize' => 'wp_kses_post',
			),

			array(
				'id'       => $this->prefix . 'single_meta_before',
				'type'     => 'textarea',
				'label'    => __( 'Before Recipe Meta', 'boo-recipes' ),
				'desc'     => sprintf(
					__( 'You may also use action hook %s', 'boo-recipes' ),
					"<code>boorecipe_single_meta_before</code>"
				),
				'sanitize' => 'wp_kses_post',
			),

			array(
				'id'       => $this->prefix . 'single_meta_after',
				'type'     => 'textarea',
				'label'    => __( 'After Recipe Meta', 'boo-recipes' ),
				'desc'     => sprintf(
					__( 'You may also use action hook %s', 'boo-recipes' ),
					"<code>boorecipe_single_meta_after</code>"
				),
				'sanitize' => 'wp_kses_post',
			),

			array(
				'id'       => $this->prefix . 'single_body_before',
				'type'     => 'textarea',
				'label'    => __( 'Before Recipe Body', 'boo-recipes' ),
				'desc'     => sprintf(
					__( 'You may also use action hook %s', 'boo-recipes' ),
					"<code>boorecipe_single_body_before</code>"
				),
				'sanitize' => 'wp_kses_post',
			),

			array(
				'id'       => $this->prefix . 'single_body_after',
				'type'     => 'textarea',
				'label'    => __( 'After Recipe Body', 'boo-recipes' ),
				'desc'     => sprintf(
					__( 'You may also use action hook %s', 'boo-recipes' ),
					"<code>boorecipe_single_body_after</code>"
				),
				'sanitize' => 'wp_kses_post',
			),

			array(
				'id'       => $this->prefix . 'single_article_before_start',
				'type'     => 'textarea',
				'label'    => __( 'Before Recipe Start', 'boo-recipes' ),
				'desc'     => sprintf(
					__( 'You may also use action hook %s', 'boo-recipes' ),
					"<code>boorecipe_single_article_before_start</code>"
				),
				'sanitize' => 'wp_kses_post',
			),


			array(
				'id'       => $this->prefix . 'single_article_after_end',
				'type'     => 'textarea',
				'label'    => __( 'After Recipe End', 'boo-recipes' ),
				'desc'     => sprintf(
					__( 'You may also use action hook %s', 'boo-recipes' ),
					"<code>boorecipe_single_article_after_end</code>"
				),
				'sanitize' => 'wp_kses_post',
			),

		) );

		return $options_fields;
	}

	/** @noinspection PhpUnusedParameterInspection */
	/**
	 * @hooked      boorecipe_options_args_array        10
	 *
	 * @param array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	// Activation tab removed - replaced with System Information tab

	public function get_options_value( $option_id ) {
		return Boorecipe_Premium_Globals::get_options_value( $option_id );
	}

	/**
	 * @hooked      recipe_options_search_form_section_fields_array        10
	 *
	 * @param array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	public function filter_options_args_array_search_form( $options_fields ) {

		$options_fields[] = array(
			'id'      => $this->prefix . 'search_form_filters',
			'type'    => 'multicheck',
			'label'   => __( 'Select Filters to include in Search Form', 'boo-recipes' ),
			'options' => array(
				'recipe_category' => __( 'Category', 'boo-recipes' ),
				'recipe_cuisine'  => __( 'Cuisine', 'boo-recipes' ),
				'skill_level'     => __( 'Skill Level', 'boo-recipes' ),
				'keyword'         => __( 'Keyword', 'boo-recipes' ),
			),
			'default' => array( 'recipe_category' => 'recipe_category', 'skill_level' => 'skill_level' ),
		);

		return $options_fields;
	}

	/**
	 * @hooked      boorecipe_filter_options_recipe_single        10
	 *
	 * @param array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	public function filter_options_recipe_single( $options_fields ) {

		$author_box_fields = array();

		$author_box_fields[] = array(
			'id'      => $this->prefix . 'show_author_box',
			'type'    => 'select',
			'label'   => __( 'Show Author Box', 'boo-recipes' ),
			'desc'    => __( 'If you choose to enable this option, author will be shown in a box before comments', 'boo-recipes' ) . '. ' . __( 'This option will not work with External Author', 'boo-recipes' ),
			'default' => 'no',
			'options' => array(
				'yes' => esc_html__( 'Yes', 'boo-recipes' ),
				'no'  => esc_html__( 'No', 'boo-recipes' )
			),
		);

		$author_box_fields[] = array(
			'id'       => $this->prefix . 'author_link_label',
			'type'     => 'text',
			'label'    => __( 'Label for All Recipes By [Author Name]', 'boo-recipes' ),
			'class'    => 'text-class',
			'desc'     => __( 'Enter text if you want to override.', 'boo-recipes' ) . " " .
			              sprintf(
				              __( 'use %s where you want to add author name. Example: All Recipes by %s', 'boo-recipes' ), '<b>%author</b>', '%author' ),
			'sanitize' => 'sanitize_text_field',
		);


		$author_box_fields[] = array(
			'id'      => $this->prefix . 'enable_ratings',
			'type'    => 'select',
			'label'   => __( 'Enable Ratings', 'boo-recipes' ),
			'desc'    => __( 'Do you Want to enable user ratings with comments?', 'boo-recipes' ),
			'default' => 'yes',
			'options' => array(
				'yes' => esc_html__( 'Yes', 'boo-recipes' ),
				'no'  => esc_html__( 'No', 'boo-recipes' )
			),
		);

		$options_fields = array_merge( $options_fields, $author_box_fields );


		$related_recipes_fields = array();

		$related_recipes_fields[] = array(
			'id'      => $this->prefix . 'related_recipes_show',
			'type'    => 'select',
			'label'   => __( 'Show Related Recipes?', 'boo-recipes' ),
			'default' => $this->get_default_options( 'related_recipes_show' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'boo-recipes' ),
				'no'  => esc_html__( 'No', 'boo-recipes' )
			),
		);


		$related_recipes_fields[] = array(
			'id'         => $this->prefix . 'related_recipes_basis',
			'type'       => 'select',
			'label'      => __( 'Related Recipes Basis', 'boo-recipes' ),
			'options'    => boorecipe_get_recipe_registered_taxonomy_array(),
			'dependency' => array( 'related_recipes_show', '==', 'true' ),
			'default'    => $this->get_default_options( 'related_recipes_basis' ),
			'sanitize'   => 'sanitize_text_field',
		);

		$related_recipes_fields[] = array(
			'id'         => $this->prefix . 'related_recipes_layout',
			'type'       => 'select',
			'label'      => __( 'Related Recipes Layout', 'boo-recipes' ),
			'options'    => boorecipe_get_recipe_archive_layouts_array(),
			'dependency' => array( 'related_recipes_show', '==', 'true' ),
			'default'    => $this->get_default_options( 'related_recipes_layout' ),
			'sanitize'   => 'sanitize_text_field',
		);

		$related_recipes_fields[] = array(
			'id'         => $this->prefix . 'related_recipes_limit',
			'type'       => 'number',
			'label'      => __( 'Related Recipes Limit', 'boo-recipes' ),
			'default'    => $this->get_default_options( 'related_recipes_limit' ),
			'dependency' => array( 'related_recipes_show', '==', 'true' ),
			'sanitize'   => 'boorecipe_sanitize_absint',
		);

		$related_recipes_fields[] = array(
			'id'         => $this->prefix . 'related_recipes_per_row',
			'type'       => 'number',
			'label'      => __( 'Related Recipes Per Row', 'boo-recipes' ),
			'default'    => $this->get_default_options( 'related_recipes_per_row' ),
			'dependency' => array( 'related_recipes_show', '==', 'true' ),
			'sanitize'   => 'boorecipe_sanitize_absint',
		);

		$related_recipes_fields[] = array(
			'id'      => $this->prefix . 'show_recipe_tool_img',
			'type'    => 'select',
			'label'   => __( 'Show Recipes tools images', 'boo-recipes' ),
			'default' => $this->get_default_options( 'show_recipe_tool_img' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'boo-recipes' ),
				'no'  => esc_html__( 'No', 'boo-recipes' )
			),
		);

		$related_recipes_fields[] = array(
			'id'          => $this->prefix . 'recipe_tool_default_img_url',
			'type'        => 'media',
			'label'       => __( 'Recipe Tool Default image', 'boo-recipes' ),
			'description' => __( 'Select the image you want to use if no recipe tool image found', 'boo-recipes' ),
			'width'       => 150,
			'height'      => 150,
			'max_width'   => 150
		);

		$related_recipes_fields[] = array(
			'id'      => $this->prefix . 'show_cooking_method_img',
			'type'    => 'select',
			'label'   => __( 'Show Cooking method images', 'boo-recipes' ),
			'default' => $this->get_default_options( 'show_cooking_method_img' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'boo-recipes' ),
				'no'  => esc_html__( 'No', 'boo-recipes' )
			),
		);

		$related_recipes_fields[] = array(
			'id'          => $this->prefix . 'cooking_method_default_img_url',
			'type'        => 'media',
			'label'       => __( 'Cooking Default image', 'boo-recipes' ),
			'description' => __( 'Select the image you want to use if no recipe tool image found', 'boo-recipes' ),
			'width'       => 150,
			'height'      => 150,
			'max_width'   => 150
		);

		$options_fields = array_merge( $options_fields, $related_recipes_fields );

//var_dump_pretty( $options_fields);
		return $options_fields;
	}

	/**
	 * @hooked      boorecipe_filter_options_recipe_single_style        10
	 *
	 * @param array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	public function filter_options_recipe_single_style( $options_fields ) {

		$options_fields['style2'] = sprintf( __( 'Style %s', 'boo-recipes' ), 2 );
		$options_fields['style3'] = sprintf( __( 'Style %s', 'boo-recipes' ), 3 );
		$options_fields['style4'] = sprintf( __( 'Style %s', 'boo-recipes' ), 4 );

		return $options_fields;
	}

	/**
	 * @hooked      boorecipe_filter_options_recipe_archive        10
	 *
	 * @param array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	public function filter_options_recipe_archive( $options_fields ) {


		$archive_fields = array();

		$archive_fields[] = array(
			'id'      => $this->prefix . 'cooking_method_slug',
			'type'    => 'text',
			'label'   => __( 'Cooking Method Slug', 'boo-recipes' ),
			'default' => $this->get_default_options( 'cooking_method_slug' ),
			'desc'    => sprintf( __( "You will need to re-save %spermalinks%s after changing this value", "boo-recipes" ), '<a href=' . get_admin_url() . "options-permalink.php" . ' target="_blank">', '</a>' ),

		);

		$archive_fields[] = array(
			'id'      => $this->prefix . 'recipe_cuisine_slug',
			'type'    => 'text',
			'label'   => __( 'Recipe Cuisine Slug', 'boo-recipes' ),
			'default' => $this->get_default_options( 'recipe_cuisine_slug' ),
			'desc'    => sprintf( __( "You will need to re-save %spermalinks%s after changing this value", "boo-recipes" ), '<a href=' . get_admin_url() . "options-permalink.php" . ' target="_blank">', '</a>' ),
		);

		$archive_fields[] = array(
			'id'      => $this->prefix . 'recipe_tool_slug',
			'type'    => 'text',
			'label'   => __( 'Recipe Tool Slug', 'boo-recipes' ),
			'default' => $this->get_default_options( 'recipe_tool_slug' ),
			'desc'    => sprintf( __( "You will need to re-save %spermalinks%s after changing this value", "boo-recipes" ), '<a href=' . get_admin_url() . "options-permalink.php" . ' target="_blank">', '</a>' ),
		);

		// Color settings moved to appear after "Heading Tag for Recipes Archive" in main admin class

		$archive_fields[] = array(
			'id'      => $this->prefix . 'card_content_alignment',
			'type'    => 'select',
			'label'   => __( 'Card Content Alignment', 'boo-recipes' ),
			'options' => array(
				'left'   => __( 'Left', 'boo-recipes' ),
				'right'  => __( 'Right', 'boo-recipes' ),
				'center' => __( 'Center', 'boo-recipes' ),
			),
			'default' => $this->get_default_options( 'card_content_alignment' ),
		);


		$archive_fields[] = array(
			'id'      => $this->prefix . 'show_rounded_card_border',
			'type'    => 'select',
			'label'   => __( 'Card Rounded Border?', 'boo-recipes' ),
			'desc'    => __( 'Do you want to make the recipe cards rounded?', 'boo-recipes' ),
			'default' => $this->get_default_options( 'show_rounded_card_border' ),
			'options' => array( 'yes' => 'Yes', 'no' => 'No' ),
		);

		$archive_fields[] = array(
			'id'       => $this->prefix . 'card_border_radius_pixels',
			'type'     => 'number',
			'label'    => __( 'Card Rounded Border Radius', 'boo-recipes' ),
			'desc'     => __( 'in pixels', 'boo-recipes' ),
			'default'  => $this->get_default_options( 'card_border_radius_pixels' ),
//			'dependency'  => array( 'show_rounded_card_border', '==', 'true' ),
			'sanitize' => 'boorecipe_sanitize_absint',
		);

		$archive_fields[] = array(
			'id'         => $this->prefix . 'card_border_pixels',
			'type'       => 'number',
			'label'      => __( 'Card border in pixels', 'boo-recipes' ),
			'desc'       => __( 'in pixels', 'boo-recipes' ),
			'default'    => $this->get_default_options( 'card_border_pixels' ),
			'dependency' => array( 'show_rounded_card_border', '==', 'true' ),
			'min'        => '0',
			'max'        => '50',
			'step'       => '1',
//			'sanitize'    => 'sanitize_text_field',

		);

		$archive_fields[] = array(
			'id'         => $this->prefix . 'color_card_border',
			'type'       => 'color',
			'label'      => __( 'Card Border Color', 'boo-recipes' ),
			'dependency' => array( 'show_rounded_card_border', '==', 'true' ),
			'default'    => $this->get_default_options( 'color_card_border' ),
			'rgba'       => true,
		);


//		array_splice( $options_fields, $cards_fields_pos, 0, $cards_fields );

		$options_fields = array_merge( $options_fields, $archive_fields );

		return $options_fields;
	}


	/**
	 * @hooked      boorecipe_options_args_array        10
	 *
	 * @param array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	public function filter_options_uninstall_section( $options_fields ) {


		$options_fields[] = array(
			'id'      => $this->prefix . 'uninstall_delete_comment_meta',
			'type'    => 'select',
			'label'   => __( 'Delete Ratings/Comments Data', 'boo-recipes' ),
			'desc'    => __( 'Delete all recipes ratings/comments data at uninstall?', 'boo-recipes' ),
			'default' => $this->get_default_options( 'uninstall_delete_comment_meta' ),
			'options' => array( 'yes' => 'Yes', 'no' => 'No' ),

		);

		return $options_fields;

	}
	/*
	 * Register Sidebars and Widgets for Recipes
	 *
	 * @param string $key
	 *
	 * @return string $key
	 *
	 */

	/**
	 * @hooked      boorecipe_filter_options_recipe_archive_layout        10
	 *
	 * @param array $options_array
	 *
	 * @return      array $options_array
	 *
	 */
	public function filter_options_recipe_archive_layout( $options_array ) {

		$options_array['modern']  = __( 'Modern', 'boo-recipes' );
		$options_array['overlay'] = __( 'Overlay', 'boo-recipes' );

		return $options_array;
	}

}
