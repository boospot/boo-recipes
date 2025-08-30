<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Premium_Admin' ) ) {
	return;
}

// Require the class file from parent plugin as the premium class is extending that class
// For unified plugin, the parent class is in the same plugin
require_once BOORECIPE_BASE_DIR . 'admin/class-boorecipe-admin.php';

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/raoabid
 * @since      1.0.0
 *
 * @package    Boorecipe_Premium
 * @subpackage Boorecipe_Premium/admin
 */
class Boorecipe_Premium_Admin extends Boorecipe_Admin {

	/**
	 * @hooked      boorecipe_options_args_array        10
	 *
	 * @param       array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	public function filter_options_args_array_add_actions( $options_fields ) {

		/*
		 * Labels
		 */
		$position_of_fields_labels      = 4;
		$labels_fields                  = array();
		$labels_fields['fields_labels'] = array(
			'id'     => 'fields_labels',
			'name'   => 'fields_labels',
			'title'  => __( 'Labels', 'boo-recipes' ),
			'icon'   => 'dashicons-editor-textcolor',
			'fields' => apply_filters( 'boorecipe_options_fields_labels', array(

				array(
					'id'         => 'recipe_category_label',
					'type'       => 'text',
					'title'      => __( 'Category Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'recipe_category_label' ),
					),

				),

				array(
					'id'         => 'recipe_cuisine_label',
					'type'       => 'text',
					'title'      => __( 'Cuisine Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'recipe_cuisine_label' ),
					),

				),

				array(
					'id'         => 'skill_level_label',
					'type'       => 'text',
					'title'      => __( 'Skill Level Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'skill_level_label' ),
					),
				),

				array(
					'id'         => 'cooking_method_label',
					'type'       => 'text',
					'title'      => __( 'Cooking Method Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'recipe_tags_label' ),
					),
				),

				array(
					'id'         => 'recipe_tags_label',
					'type'       => 'text',
					'title'      => __( 'Tags Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'recipe_tags_label' ),
					),
				),


				array(
					'id'         => 'prep_time_label',
					'type'       => 'text',
					'title'      => __( 'Prep Time Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'prep_time_label' ),
					),

				),

				array(
					'id'         => 'cook_time_label',
					'type'       => 'text',
					'title'      => __( 'Cook Time Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'cook_time_label' ),
					),
				),

				array(
					'id'         => 'total_time_label',
					'type'       => 'text',
					'title'      => __( 'Total Time Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'total_time_label' ),
					),
				),

				array(
					'id'         => 'time_unit_minutes_label',
					'type'       => 'text',
					'title'      => __( 'Minutes (time unit) Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'time_unit_minutes_label' ),
					),
				),

				array(
					'id'         => 'time_unit_hours_label',
					'type'       => 'text',
					'title'      => __( 'Hours (time unit) Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'time_unit_hours_label' ),
					),
				),

				array(
					'id'         => 'yields_label',
					'type'       => 'text',
					'title'      => __( 'Yields Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'yields_label' ),
					),
				),

				array(
					'id'         => 'keyword_label',
					'type'       => 'text',
					'title'      => __( 'Keywords Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'keyword_label' ),
					),
				),


				array(
					'id'         => 'ingredients_label',
					'type'       => 'text',
					'title'      => __( 'Ingredients Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'ingredients_label' ),
					),
				),

				array(
					'id'         => 'directions_label',
					'type'       => 'text',
					'title'      => __( 'Directions Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'directions_label' ),
					),
				),

				array(
					'id'         => 'nutrition_label',
					'type'       => 'text',
					'title'      => __( 'Nutrition Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'nutrition_label' ),
					),
				),

				array(
					'id'         => 'nutrition_facts_label',
					'type'       => 'text',
					'title'      => __( 'Nutrition Facts Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'nutrition_facts_label' ),
					),
				),

				array(
					'id'         => 'recipe_ratings_label',
					'type'       => 'text',
					'title'      => __( 'Ratings Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'recipe_ratings_label' ),
					),
				),

				array(
					'id'         => 'rating_start_label',
					'type'       => 'text',
					'title'      => __( 'Ratings string start with', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'rating_start_label' ),
					),
				),

				array(
					'id'         => 'rating_based_on_label',
					'type'       => 'text',
					'title'      => __( 'Ratings string "based on"', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'rating_based_on_label' ),
					),
				),

				array(
					'id'         => 'rating_customer_reviews_label',
					'type'       => 'text',
					'title'      => __( 'Ratings string ends', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'rating_customer_reviews_label' ),
					),
				),

				array(
					'id'         => 'related_recipes_label',
					'type'       => 'text',
					'title'      => __( 'Related Recipes Label', 'boo-recipes' ),
					'dependency' => array( 'related_recipes_show', '==', 'true' ),
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'related_recipes_label' ),
					),
				),

				array(
					'id'         => 'additional_notes_label',
					'type'       => 'text',
					'title'      => __( 'Additional Notes Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'additional_notes_label' ),
					),
				),

				array(
					'id'         => 'submit_button_label',
					'type'       => 'text',
					'title'      => __( 'Submit Button Label', 'boo-recipes' ),
					'class'      => 'text-class',
					'sanitize'   => 'sanitize_text_field',
					'attributes' => array(
						'placeholder' => $this->get_default_options( 'submit_button_label' ),
					),

				),


			) )
		);

		array_splice( $options_fields, $position_of_fields_labels, 0, $labels_fields );

		/*
		 * Hooks
		 */
		$position_of_action_hooks_elements   = 5;
		$hooks_fields                        = array();
		$hooks_fields['recipe_action_hooks'] = array(
			'name'   => 'recipe_action_hooks',
			'title'  => __( 'Insertion Points', 'boo-recipes' ),
			'icon'   => 'dashicons-lightbulb',
			'fields' => array(


				array(
					'id'          => 'single_media_before',
					'type'        => 'textarea',
					'title'       => __( 'Before Recipe Media', 'boo-recipes' ),
					'description' => __( 'Anything you put here will appear before recipe media (image) . Shortcodes also allowed.', 'boo-recipes' ),
					'after'       => __( 'You may also use action hook <code>boorecipe_single_media_before</code>', 'boo-recipes' ),
					'sanitize'    => 'wp_kses_post',
				),

				array(
					'id'          => 'single_media_after',
					'type'        => 'textarea',
					'title'       => __( 'After Recipe Media', 'boo-recipes' ),
					'description' => __( 'Anything you put here will appear after recipe media (image) . Shortcodes also allowed.', 'boo-recipes' ),
					'after'       => __( 'You may also use action hook <code>boorecipe_single_media_after</code>', 'boo-recipes' ),
					'sanitize'    => 'wp_kses_post',
				),

				array(
					'id'          => 'single_head_before',
					'type'        => 'textarea',
					'title'       => __( 'Before Recipe Head', 'boo-recipes' ),
					'description' => __( 'Anything you put here will appear before recipe head section. Shortcodes also allowed.', 'boo-recipes' ),
					'after'       => __( 'You may also use action hook <code>boorecipe_single_head_before</code>', 'boo-recipes' ),
					'sanitize'    => 'wp_kses_post',
				),

				array(
					'id'          => 'single_head_after',
					'type'        => 'textarea',
					'title'       => __( 'After Recipe Head', 'boo-recipes' ),
					'description' => __( 'Anything you put here will appear after recipe head section. Shortcodes also allowed.', 'boo-recipes' ),
					'after'       => __( 'You may also use action hook <code>boorecipe_single_head_after</code>', 'boo-recipes' ),
					'sanitize'    => 'wp_kses_post',
				),

				array(
					'id'          => 'single_meta_before',
					'type'        => 'textarea',
					'title'       => __( 'Before Recipe Meta', 'boo-recipes' ),
					'description' => __( 'Anything you put here will appear before recipe meta section. Shortcodes also allowed.', 'boo-recipes' ),
					'after'       => __( 'You may also use action hook <code>boorecipe_single_meta_before</code>', 'boo-recipes' ),
					'sanitize'    => 'wp_kses_post',
				),

				array(
					'id'          => 'single_meta_after',
					'type'        => 'textarea',
					'title'       => __( 'After Recipe Meta', 'boo-recipes' ),
					'description' => __( 'Anything you put here will appear after recipe meta section. Shortcodes also allowed.', 'boo-recipes' ),
					'after'       => __( 'You may also use action hook <code>boorecipe_single_meta_after</code>', 'boo-recipes' ),
					'sanitize'    => 'wp_kses_post',
				),

				array(
					'id'          => 'single_body_before',
					'type'        => 'textarea',
					'title'       => __( 'Before Recipe Body', 'boo-recipes' ),
					'description' => __( 'Anything you put here will appear before recipe body section. Shortcodes also allowed.', 'boo-recipes' ),
					'after'       => __( 'You may also use action hook <code>boorecipe_single_body_before</code>', 'boo-recipes' ),
					'sanitize'    => 'wp_kses_post',
				),

				array(
					'id'          => 'single_body_after',
					'type'        => 'textarea',
					'title'       => __( 'After Recipe Body', 'boo-recipes' ),
					'description' => __( 'Anything you put here will appear after recipe body section. Shortcodes also allowed.', 'boo-recipes' ),
					'after'       => __( 'You may also use action hook <code>boorecipe_single_body_after</code>', 'boo-recipes' ),
					'sanitize'    => 'wp_kses_post',
				),

				array(
					'id'          => 'single_article_before_start',
					'type'        => 'textarea',
					'title'       => __( 'Before Recipe Start', 'boo-recipes' ),
					'description' => __( 'Anything you put here will appear before recipe start. Shortcodes also allowed.', 'boo-recipes' ),
					'after'       => __( 'You may also use action hook <code>boorecipe_single_article_before_start</code>', 'boo-recipes' ),
					'sanitize'    => 'wp_kses_post',
				),


				array(
					'id'          => 'single_article_after_end',
					'type'        => 'textarea',
					'title'       => __( 'After Recipe End', 'boo-recipes' ),
					'description' => __( 'Anything you put here will appear after recipe end. Shortcodes also allowed.', 'boo-recipes' ),
					'after'       => __( 'You may also use action hook <code>boorecipe_single_article_after_end</code>', 'boo-recipes' ),
					'sanitize'    => 'wp_kses_post',
				),

			)
		);


		array_splice( $options_fields, $position_of_action_hooks_elements, 0, $hooks_fields );


		return $options_fields;
	}


	/**
	 * @hooked      boorecipe_options_args_array        10
	 *
	 * @param       array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	public function filter_options_args_array_activation_tab_update( $options_fields ) {

		if ( isset( $options_fields['recipe_plugin_activation'] ) && is_array( $options_fields['recipe_plugin_activation'] ) ):

			$activation_tab = $options_fields['recipe_plugin_activation'];

			$activation_tab['title'] = __( 'Plugin Activation', 'boo-recipes' );

			// For unified plugin, we don't need license activation
			$activation_tab['fields'] = apply_filters( 'recipe_options_plugin_activation_section', array(
				array(
					'id'          => 'premium_features_info',
					'type'        => 'content',
					'title'       => __( 'Premium Features Included', 'boo-recipes' ),
					'content'     => __( 'This Pro version includes all premium features. No license activation required.', 'boo-recipes' ),
				),
			) );

			$options_fields['recipe_plugin_activation'] = $activation_tab;
		endif;

		return $options_fields;
	}

	/**
	 * @hooked      recipe_options_search_form_section_fields_array        10
	 *
	 * @param       array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	public function filter_options_args_array_search_form( $options_fields ) {

		$options_fields[] = array(
			'id'      => 'search_form_filters',
			'type'    => 'tap_list',
			'title'   => __( 'Select Filters to include in Search Form', 'boo-recipes' ),
			'options' => array(
				'recipe_category' => 'Category',
				'recipe_cuisine'  => 'Cuisine',
				'skill_level'     => 'Skill Level',
				'keyword'         => 'Keyword',
			),
			'default' => array( 'recipe_category', 'skill_level' ),
		);

		 return $options_fields;
	}

	/**
	 * @hooked      boorecipe_filter_options_recipe_single        10
	 *
	 * @param       array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	public function filter_options_recipe_single( $options_fields ) {

		$author_box_fields_pos = 13;

		$author_box_fields = array();

		$author_box_fields[] = array(
			'id'          => 'show_author_box',
			'type'        => 'switcher',
			'title'       => __( 'Show Author Box', 'boo-recipes' ),
			'description' => __( 'This option will not work with External Author', 'boo-recipes' ),
			'label'       => __( 'If you choose to enable this option, author will be shown in a box before comments', 'boo-recipes' ),
			'default'     => 'no',
		);

		$author_box_fields[] = array(
			'id'          => 'author_link_label',
			'type'        => 'text',
			'title'       => __( 'Label for All Recipes By [Author Name]', 'boo-recipes' ),
			'class'       => 'text-class',
			'description' => __( 'Enter text if you want to override.', 'boo-recipes' ),
			'after'       => __( 'use <b>%author</b> where you want to add author name. Example: All Recipes by %author', 'boo-recipes' ),
			'sanitize'    => 'sanitize_text_field',
		);


		$author_box_fields[] = array(
			'id'      => 'enable_ratings',
			'type'    => 'switcher',
			'title'   => __( 'Enable Ratings', 'boo-recipes' ),
			'label'   => __( 'Do you Want to enable user ratings with comments?', 'boo-recipes' ),
			'default' => 'yes',
		);


		array_splice( $options_fields, $author_box_fields_pos, 0, $author_box_fields );


		$related_recipes_fields_pos = 15;

		$related_recipes_fields = array();


		$related_recipes_fields[] = array(
			'id'      => 'related_recipes_show',
			'type'    => 'switcher',
			'title'   => __( 'Show Related Recipes?', 'boo-recipes' ),
			'default' => $this->get_default_options( 'related_recipes_show' ),
		);


		$related_recipes_fields[] = array(
			'id'         => 'related_recipes_basis',
			'type'       => 'select',
			'title'      => __( 'Related Recipes Basis', 'boo-recipes' ),
			'options'    => boorecipe_get_recipe_registered_taxonomy_array(),
			'dependency' => array( 'related_recipes_show', '==', 'true' ),
			'default'    => $this->get_default_options( 'related_recipes_basis' ),
			'sanitize'   => 'sanitize_text_field',
		);

		$related_recipes_fields[] = array(
			'id'         => 'related_recipes_layout',
			'type'       => 'select',
			'title'      => __( 'Related Recipes Layout', 'boo-recipes' ),
			'options'    => boorecipe_get_recipe_archive_layouts_array(),
			'dependency' => array( 'related_recipes_show', '==', 'true' ),
			'default'    => $this->get_default_options( 'related_recipes_layout' ),
			'sanitize'   => 'sanitize_text_field',
		);

		$related_recipes_fields[] = array(
			'id'         => 'related_recipes_limit',
			'type'       => 'number',
			'title'      => __( 'Related Recipes Limit', 'boo-recipes' ),
			'default'    => $this->get_default_options( 'related_recipes_limit' ),
			'dependency' => array( 'related_recipes_show', '==', 'true' ),
			'sanitize'   => 'boorecipe_sanitize_absint',
		);

		$related_recipes_fields[] = array(
			'id'         => 'related_recipes_per_row',
			'type'       => 'number',
			'title'      => __( 'Related Recipes Per Row', 'boo-recipes' ),
			'default'    => $this->get_default_options( 'related_recipes_per_row' ),
			'dependency' => array( 'related_recipes_show', '==', 'true' ),
			'sanitize'   => 'boorecipe_sanitize_absint',
		);

		array_splice( $options_fields, $related_recipes_fields_pos, 0, $related_recipes_fields );


		return $options_fields;
	}

	/**
	 * @hooked      boorecipe_filter_options_recipe_single_style        10
	 *
	 * @param       array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	public function filter_options_recipe_single_style( $options_fields ) {

		$options_fields['style2'] = 'https://dummyimage.com/100x80/dd9933/fff.gif&text=Style2';
		$options_fields['style3'] = 'https://dummyimage.com/100x80/ff4400/fff.gif&text=Style3';
		$options_fields['style4'] = 'https://dummyimage.com/100x80/yellow/fff.gif&text=Style4';

		return $options_fields;
	}

	/**
	 * @hooked      boorecipe_filter_options_recipe_archive        10
	 *
	 * @param       array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	public function filter_options_recipe_archive( $options_fields ) {

		$cards_fields_pos = 10;

		$cards_fields = array();


		$cards_fields[] = array(
			'id'      => 'color_archive_key_points_bg',
			'type'    => 'color',
			'title'   => __( 'Key Points Background Color', 'boo-recipes' ),
			'default' => $this->get_default_options( 'color_archive_key_points_bg' ),
			'rgba'    => true,
		);

		$cards_fields[] = array(
			'id'      => 'color_archive_hover_overlay',
			'type'    => 'color',
			'title'   => __( 'Hover Overlay Color', 'boo-recipes' ),
			'default' => $this->get_default_options( 'color_archive_hover_overlay' ),
			'rgba'    => true,
		);

		$cards_fields[] = array(
			'id'      => 'card_content_alignment',
			'type'    => 'select',
			'title'   => __( 'Card Content Alignment', 'boo-recipes' ),
			'options' => array(
				'left'   => __( 'Left', 'boo-recipes' ),
				'right'  => __( 'Right', 'boo-recipes' ),
				'center' => __( 'Center', 'boo-recipes' ),
			),
			'default' => $this->get_default_options( 'card_content_alignment' ),
		);


		$cards_fields[] = array(
			'id'      => 'show_rounded_card_border',
			'type'    => 'switcher',
			'title'   => __( 'Card Rounded Border?', 'boo-recipes' ),
			'label'   => __( 'Do you want to make the recipe cards rounded?', 'boo-recipes' ),
			'default' => $this->get_default_options( 'show_rounded_card_border' ),
		);

		$cards_fields[] = array(
			'id'          => 'card_border_radius_pixels',
			'type'        => 'number',
			'title'       => __( 'Card Rounded Border Radius', 'boo-recipes' ),
			'description' => __( 'in pixels', 'boo-recipes' ),
			'default'     => $this->get_default_options( 'card_border_radius_pixels' ),
			'dependency'  => array( 'show_rounded_card_border', '==', 'true' ),
			'sanitize'    => 'boorecipe_sanitize_absint',

		);

		$cards_fields[] = array(
			'id'          => 'card_border_pixels',
			'type'        => 'number',
			'title'       => __( 'Card border in pixels', 'boo-recipes' ),
			'description' => __( 'in pixels', 'boo-recipes' ),
			'default'     => $this->get_default_options( 'card_border_pixels' ),
			'dependency'  => array( 'show_rounded_card_border', '==', 'true' ),
			'min'         => '0',
			'max'         => '50',
			'step'        => '1',
//			'sanitize'    => 'sanitize_text_field',

		);

		$cards_fields[] = array(
			'id'         => 'color_card_border',
			'type'       => 'color',
			'title'      => __( 'Card Border Color', 'boo-recipes' ),
			'dependency' => array( 'show_rounded_card_border', '==', 'true' ),
			'default'    => $this->get_default_options( 'color_card_border' ),
			'rgba'       => true,
		);

		array_splice( $options_fields, $cards_fields_pos, 0, $cards_fields );


		return $options_fields;
	}


	/**
	 * @hooked      boorecipe_options_args_array        10
	 *
	 * @param       array $options_fields
	 *
	 * @return      array $options_fields
	 *
	 */
	public function filter_options_uninstall_section( $options_fields ) {


		$options_fields[] = array(
			'id'          => 'uninstall_delete_comment_meta',
			'type'        => 'switcher',
			'title'       => __( 'Delete Ratings/Comments Data', 'boo-recipes' ),
			'description' => __( 'Delete all recipes ratings/comments data at uninstall?', 'boo-recipes' ),
			'help'        => __( 'green = Yes & red = No', 'boo-recipes' ),
			'default'     => $this->get_default_options( 'uninstall_delete_comment_meta' ),
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
	 * @param       array $options_array
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

