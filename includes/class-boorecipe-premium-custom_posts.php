<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Premium_Post_Types' ) ) {
	return;
}


/**
 * This class will extend the functionality of the main class defined in base version of plugin
 */
// Require the class file from parent plugin as the premium class is extending that class
require_once BOORECIPE_BASE_DIR . 'includes/class-boorecipe-custom_posts.php';

class Boorecipe_Premium_Post_Types extends Boorecipe_Post_Types {


	/**
	 * Registering Metabox for Additional Media
	 */
	public function register_meta_box_premium( $meta_boxes ) {

		$meta_boxes[] = $this->get_metabox_array_additional_media();

		return $meta_boxes;
	}

	/**
	 *
	 */
	public function get_metabox_array_additional_media() {

		$prefix = $this->prefix;

		$metabox_fields_additional_media = array(

			array(
				'id'                => $prefix . 'show_image_slider',
				'type'              => 'switch',
				'name'              => __( 'Show Image Slider', 'boo-recipes' ),
				'label'             => __( 'Do you want to show image slider for this recipe?', 'boo-recipes' ),
				'std'               => 0,
				'sanitize_callback' => 'sanitize_key'
			),

			array(
				'id'               => $prefix . 'recipe_image_slider_items_attached',
				'name'             => __( 'Slider images', 'boo-recipes' ),
				'type'             => 'image_advanced',
				'force_delete'     => false,
				'max_file_uploads' => 6,
				'max_status'       => 'false',
				'image_size'       => 'thumbnail',
			),

			// Video Recipe
			array(
				'id'                => $prefix . 'is_video_recipe',
				'type'              => 'switch',
				'name'              => __( 'is it a Video Recipe?', 'boo-recipes' ),
				'desc'              => __( 'Do you want to show video instead of featured image?', 'boo-recipes' ),
				'std'               => 0,
				'sanitize_callback' => 'sanitize_key'
			),


			array(
				'id'         => $prefix . 'video_recipe_url',
				'type'       => 'oembed',
				'name'       => __( 'Video URL', 'boo-recipes' ),
				'attributes' => array(
					'placeholder' => __( 'Youtube, Vimeo, Self Hosted', 'boo-recipes' ),
				),
				'desc'       => sprintf( esc_html__( 'Youtube, Vimeo, Self Hosted or other embed options: %s', 'boo-recipes' ), 'https://codex.wordpress.org/Embeds' ),
			),
		);

		$metabox_array_additional_media = array(
			'id'             => 'boorecipe-recipe-meta-additional-media',
			'title'          => esc_html__( 'Recipe Additional Media', 'boo-recipes' ),
			'post_types'     => array( 'boo_recipe' ),
			'context'        => 'normal',
			'priority'       => 'high',
			'autosave'       => 'false',
			'fields'         => $metabox_fields_additional_media,
			'settings_pages' => 'boorecipe-update-meta',
			'tab'            => 'default',
		);

		Boorecipe_Globals::set_meta_fields( $metabox_fields_additional_media );

		return $metabox_array_additional_media;

	}

	/**
	 * Registering Metabox for Taxonomy terms
	 */
	public function register_meta_taxonomy_terms( $meta_boxes ) {

		$meta_boxes[] = array(
			'title'      => esc_html__( 'Special Fields', 'boo-recipes' ),
			'taxonomies' => [ 'recipe_tool', 'cooking_method' ],

			'fields' => apply_filters( 'boorecipes_taxonomy_metabox_fields', array(
				array(
					'name'             => esc_html__( 'Featured Image', 'boo-recipes' ),
					'id'               => 'featured_image',
					'type'             => 'image_advanced',
					'max_file_uploads' => 1,
					'image_size'       => 'thumbnail',
				),
				array(
					'name' => esc_html__( 'Override URL', 'boo-recipes' ),
					'id'   => 'override_url',
					'type' => 'url',
					'desc' => esc_html__( 'Any URL entered in this field will be used to override the default link for this term.', 'boo-recipes' )
				),
			) ),
		);


		return $meta_boxes;

	}

	/**
	 *
	 */
	public function filter_metabox_fields_ingredients_switch( $recipe_meta_fields ) {

		$prefix                     = Boorecipe_Globals::get_meta_prefix();
		$ingredient_fields_position = 10;

		$ingredient_fields = array(
			array(
				'id'       => $prefix . 'ingredients_type',
				'name'     => esc_html__( 'Ingredient Type', 'boo-recipes' ),
				'type'     => 'button_group',
				'options'  => array(
					''        => '<i class="dashicons dashicons-edit"></i>' . " " . esc_html__( 'Textarea', 'boo-recipes' ),
					'wysiwyg' => '<i class="dashicons dashicons-editor-kitchensink"></i>' . " " . esc_html__( 'WYSIWYG', 'boo-recipes' ),
				),
				'inline'   => true,
				'multiple' => false,
				'std'      => 'textarea'
			),
			array(
				'id'      => $prefix . 'ingredients_wysiwyg',
				'type'    => 'wysiwyg',
				'name'    => esc_html__( 'Ingredients', 'boo-recipes' ),
				'desc'    => __( 'Each new paragraph will be a new ingredient', 'boo-recipes' ),
				'options' => array(
					'textarea_rows' => 6,
//					'teeny'         => true,
				),
			),
		);

		array_splice( $recipe_meta_fields, $ingredient_fields_position, 0, $ingredient_fields );

		$directions_fields_position = 13;

		$directions_fields = array(
			array(
				'id'       => $prefix . 'directions_type',
				'name'     => esc_html__( 'Directions Type', 'boo-recipes' ),
				'type'     => 'button_group',
				'options'  => array(
					''        => '<i class="dashicons dashicons-edit"></i>' . " " . esc_html__( 'Textarea', 'boo-recipes' ),
					'wysiwyg' => '<i class="dashicons dashicons-editor-kitchensink"></i>' . " " . esc_html__( 'WYSIWYG', 'boo-recipes' ),
//					'underline' => '<i class="dashicons dashicons-editor-underline"></i>',
				),
				'inline'   => true,
				'multiple' => false,
				'std'      => 'textarea'
			),
			array(
				'id'      => $prefix . 'directions_wysiwyg',
				'type'    => 'wysiwyg',
				'name'    => esc_html__( 'Directions', 'boo-recipes' ),
				'desc'    => __( 'Each new paragraph will be a new Direction', 'boo-recipes' ),
				'options' => array(
					'textarea_rows' => 6,
//					'teeny'         => true,
				),
			),
		);

		array_splice( $recipe_meta_fields, $directions_fields_position, 0, $directions_fields );

		return $recipe_meta_fields;
	}

	public function filter_metabox_fields_image_slider_videos( $recipe_meta_fields ) {


		$prefix = Boorecipe_Globals::get_meta_prefix();


		$position_of_new_elements = 1;
		$new_fields               = array(
			array(
				'id'     => 'recipe_image_slider',
				'name'   => 'recipe_image_slider',
				'title'  => __( 'Recipe Additional Media', 'boo-recipes' ),
				'fields' => array(

					array(
						'id'         => $prefix . 'recipe_image_slider_style4_general_notice',
						'type'       => 'notice',
						'class'      => 'info',
						'content'    => __( '<strong>📋 Recipe Style 4:</strong> If you are using Recipe Style 4, image sliders will not be displayed. Only the featured image will be shown on Style 4.', 'boo-recipes' ),
						'sanitize'   => 'sanitize_text_field'
					),

					array(
						'id'         => $prefix . 'recipe_image_slider_notice',
						'type'       => 'notice',
						'class'      => 'danger',
						'dependency' => array(
							"{$prefix}is_video_recipe|{$prefix}show_image_slider",
							'==|==',
							'true|true'
						),
						'content'    => __( 'You may either use images slider or Video. Please deactivate image slider if you want to use video', 'boo-recipes' ),
						'sanitize'   => 'sanitize_text_field'
					),

					array(
						'id'       => $prefix . 'show_image_slider',
						'type'     => 'switcher',
						'title'    => __( 'Show Image Slider', 'boo-recipes' ),
						'label'    => __( 'Do you want to show image slider for this recipe?', 'boo-recipes' ),
						'default'  => 'no',
						'sanitize' => 'sanitize_key'
					),

					array(
						'id'         => $prefix . 'recipe_image_slider_style4_notice',
						'type'       => 'notice',
						'class'      => 'warning',
						'dependency' => array( $prefix . 'show_image_slider', '==', true ),
						'content'    => __( '<strong>⚠️ Style 4 Limitation:</strong> Image slider does not work with Recipe Style 4. Only the featured image will be displayed on Style 4, regardless of this setting.', 'boo-recipes' ),
						'sanitize'   => 'sanitize_text_field'
					),
					array(
						'id'         => $prefix . 'recipe_image_slider_items_attached',
						'type'       => 'attached',
						'title'      => __( 'Attached images', 'boo-recipes' ),
						'dependency' => array( $prefix . 'show_image_slider', '==', true ),
						'options'    => array(
							'type' => '', // attach to post (only in metabox)
						),
					),
					array(
						'id'         => $prefix . 'recipe_image_slider_items',
						'type'       => 'upload',
						'title'      => __( 'Upload images', 'boo-recipes' ),
						'dependency' => array( $prefix . 'show_image_slider', '==', true ),
						'options'    => array(
							'attach'               => true, // attach to post (only in metabox)
							'auto-upload'          => true,
							'filecount'            => '5',
							'allowed'              => array( 'png', 'jpeg', 'jpg' ),
							'delete-enabled'       => true,
							'delete-force-confirm' => false,
						),
					),

					// Video Recipe
					array(
						'id'       => $prefix . 'is_video_recipe',
						'type'     => 'switcher',
						'title'    => __( 'is it a Video Recipe?', 'boo-recipes' ),
						'label'    => __( 'Do you want to show video instead of featured image?', 'boo-recipes' ),
						'default'  => 'no',
						'sanitize' => 'sanitize_key'
					),


					array(
						'id'         => $prefix . 'video_recipe_url',
						'type'       => 'text',
						'title'      => __( 'Video URL', 'boo-recipes' ),
						'dependency' => array(
							"{$prefix}is_video_recipe|{$prefix}show_image_slider",
							'==|==',
							'true|false'
						),
						'attributes' => array(
							'placeholder' => __( 'Youtube, Vimeo, Self Hosted', 'boo-recipes' ),
						),
						'after'      => ' <i class="text-muted">' .
						                __( 'Youtube, Vimeo, Self Hosted or other embed options: https://codex.wordpress.org/Embeds ', 'boo-recipes' )
						                . '</i>',
						'sanitize'   => 'esc_url_raw'
					),
				)
			)
		);

		array_splice( $recipe_meta_fields, $position_of_new_elements, 0, $new_fields );

		return $recipe_meta_fields;

	}

	/*
	 * For adding additional Taxonomies
	 *
	 * These shall also be used for plugin activation
	 * and
	 * flush_rewrite_rules
	 */

	public function filter_taxonomies_create_args( $taxonomy_registering_array ) {

		$new_taxonomy_args = $this->get_taxonomies_create_args();

		$new_taxonomy_position = 1;

		array_splice( $taxonomy_registering_array, $new_taxonomy_position, 0, $new_taxonomy_args );

		return $taxonomy_registering_array;
	}

	/*
	 * For adding additional Taxonomies
	 */

	public function get_taxonomies_create_args() {

		$cooking_method_slug = ( ! empty( $this->get_options_value( 'cooking_method_slug' ) ) )
			? sanitize_key( $this->get_options_value( 'cooking_method_slug' ) )
			: 'cooking-method';

		$recipe_cuisine_slug = ( ! empty( $this->get_options_value( 'recipe_cuisine_slug' ) ) )
			? sanitize_key( $this->get_options_value( 'recipe_cuisine_slug' ) )
			: 'recipe-cuisine';

		$recipe_tool_slug = ( ! empty( $this->get_options_value( 'recipe_tool_slug' ) ) )
			? sanitize_key( $this->get_options_value( 'recipe_tool_slug' ) )
			: 'recipe-tool';

		$new_taxonomy_args   = array();
		$new_taxonomy_args[] = array(
			'taxonomy'   => 'cooking_method',
			'plural'     => __( 'Cooking Methods', 'boo-recipes' ),
			'single'     => __( 'Cooking Methods', 'boo-recipes' ),
			'post_types' => array( 'boo_recipe' ),
			'rewrite'    => array( 'slug' => $cooking_method_slug, 'with_front' => false )
		);

		$new_taxonomy_args[] = array(
			'taxonomy'   => 'recipe_cuisine',
			'plural'     => __( 'Recipe Cuisines', 'boo-recipes' ),
			'single'     => __( 'Recipe Cuisine', 'boo-recipes' ),
			'post_types' => array( 'boo_recipe' ),
			'rewrite'    => array( 'slug' => $recipe_cuisine_slug, 'with_front' => false )
		);

		$new_taxonomy_args[] = array(
			'taxonomy'   => 'recipe_tool',
			'plural'     => __( 'Recipe Tools', 'boo-recipes' ),
			'single'     => __( 'Recipe Tool', 'boo-recipes' ),
			'post_types' => array( 'boo_recipe' ),
			'rewrite'    => array( 'slug' => $recipe_tool_slug, 'with_front' => false )
		);

		return $new_taxonomy_args;
	}


	/*
	 * For Image Slider
	 */

	public function recipe_add_image_sizes_for_premium_features( $image_sizes_array ) {

//		$recipe_add_image_size_args = array(
//			'name'   => 'recipe_slider_thumbnail',
//			'width'  => 200,
//			'height' => 100,
//			'crop'   => true
//		);

		$image_sizes_array['recipe_slider_thumbnail'] = array(
			'name'   => 'recipe_slider_thumbnail',
			'width'  => 200,
			'height' => 100,
			'crop'   => true
		);

		$image_sizes_array['recipe_image_style2'] = array(
			'name'   => 'recipe_image_style2',
			'width'  => 768,
			'height' => 768,
			'crop'   => true
		);

		return $image_sizes_array;

	}


	/*
	 * Rating Comments
	 */
	public function ratings_fields_on_comments() {


		if ( get_post_type() != 'boo_recipe' || $this->get_options_value( 'enable_ratings' ) !== 'yes' ) {
			return;
		}


		echo '<div class="recipe-rating" data-stars="1">';

		//Current rating scale is 1 to 5. If you want the scale to be 1 to 10, then set the value of $i to 10.
		for ( $i = 5; $i > 0; $i -- ) {

			$svg_icon = Boorecipe_Globals::get_icon_font( 'star_full', 'icon-size-24' );

			echo "<label for='rating-{$i}'>{$svg_icon}
					<input type='radio' name='boorecipe_user_rating' id='rating-{$i}' value='{$i}' title='{$i} stars'/>
					<span class='screen-reader-text'>{$i} star</span></label>";
		}
//		<input type="radio" name="boorecipe_user_rating" id="rating-5" value="5" /><label for="rating-5">5</label>
		echo '</div>';
	}


	// Save the comment meta data along with comment
	public function save_ratings_on_comments_save( $comment_id ) {

		if ( ( isset( $_POST['boorecipe_user_rating'] ) ) && ( $_POST['boorecipe_user_rating'] != '' ) ) {
			$rating = wp_filter_nohtml_kses( $_POST['boorecipe_user_rating'] );
			add_comment_meta( $comment_id, 'boorecipe_user_rating', $rating );

		}
	}


	// Add the filter to check whether the comment meta data has been filled
	public function verify_user_rating_posted( $comment_data ) {

		if ( get_post_type() != 'boo_recipe' || $this->get_options_value( 'enable_ratings' ) !== 'yes' ) {
			return $comment_data;
		}


		if ( ! isset( $_POST['boorecipe_user_rating'] ) ) {
			wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.', 'boo-recipes' ) );
		}

		return $comment_data;
	}

	/*
	 * @hooked comment_text
	 *
	 * @param string $text
	 */
	public function add_star_reviews_to_posted_comments( $text ) {

		$comment_rating = get_comment_meta( get_comment_ID(), 'boorecipe_user_rating', true );

		if ( $comment_rating ) {


			$rating_html = '';

			$rating_html .= '<div class="recipe-rating">' .
			                '<span class="rating-stars">';

			//Current rating scale is 1 to 5. If you want the scale to be 1 to 10, then set the value of $i to 10.
			for ( $i = 1; $i <= 5; $i ++ ) {
				$svg         = ( $i <= $comment_rating ) ? 'star_full' : 'star_empty';
				$rating_html .= Boorecipe_Globals::get_icon_font( $svg, 'icon-size-24' );

			}

			$rating_html .= '</span></div>';


			$text = $rating_html . $text;

			return $text;
		} else {
			return $text;
		}
	}

	/*
	 * @hooked edit_comment
	 *
	 * @param int $comment_id
	 */
	public function extend_comment_edit_meta_fields( $comment_id ) {

		if ( ( isset( $_POST['boorecipe_user_rating'] ) ) && ( $_POST['boorecipe_user_rating'] != '' ) ):
			$rating = wp_filter_nohtml_kses( $_POST['boorecipe_user_rating'] );
			update_comment_meta( $comment_id, 'boorecipe_user_rating', $rating );
		else :
			delete_comment_meta( $comment_id, 'boorecipe_user_rating' );
		endif;
	}


}