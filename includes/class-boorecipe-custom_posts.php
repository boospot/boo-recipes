<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Post_Types' ) ) {
	return;
}


/**
 * This class will create required custom post types
 */
class Boorecipe_Post_Types {

	/**
	 * @var : it will be the id used for $meta
	 */
	private $meta_id;

	/**
	 * Create post types
	 */
	public function create_custom_post_type() {

		/**
		 * This is not all the fields, only what I find important. Feel free to change this function ;)
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_post_type
		 */

//		$recipe_slug = ( ! empty( $this->get_options_value( 'recipe_slug' ) ) ) ? $this->get_options_value( 'recipe_slug' ) : 'recipe';

		$post_types_fields = apply_filters( 'boorecipe_post_type_create_args', array(

			array(
				'slug'                => 'boo_recipe',
				'singular'            => __( 'Recipe', 'boorecipe' ),
				'plural'              => __( 'Recipes', 'boorecipe' ),
				'menu_name'           => __( 'Recipes', 'boorecipe' ),
				'description'         => __( 'Recipes', 'boorecipe' ),
				'has_archive'         => true,
				'hierarchical'        => false,
				'menu_icon'           => 'dashicons-carrot',
				'rewrite'             => array(
					'slug'       => 'recipe',
					'with_front' => true,
					'pages'      => true,
					'feeds'      => true,
					'ep_mask'    => EP_PERMALINK,
				),
				'menu_position'       => 21,
				'public'              => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'query_var'           => true,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'supports'            => array(
					'title',
//					'editor',
					'excerpt',
					'author',
					'thumbnail',
					'comments',
					'trackbacks',
					'custom-fields',
					'revisions',
					'page-attributes',
				),
				'custom_caps'         => true,
				'custom_caps_users'   => array(
					'administrator',
				),
				'taxonomies'          => apply_filters( 'boorecipe_taxonomies_create_args', array(

					array(
						'id'                  => 'recipe_category',
						'taxonomy'            => 'recipe_category',
						'plural'              => __( 'Recipe Categories', 'boorecipe' ),
						'single'              => __( 'Recipe Category', 'boorecipe' ),
						'post_types'          => array( 'boo_recipe' ),
						'rewrite'             => array( 'slug' => 'recipe_category', 'with_front' => false ),
						'exclude_from_search' => false
					),

					array(
						'id'                  => 'skill_level',
						'taxonomy'            => 'skill_level',
						'plural'              => __( 'Skill Levels', 'boorecipe' ),
						'single'              => __( 'Skill Level', 'boorecipe' ),
						'post_types'          => array( 'boo_recipe' ),
						'rewrite'             => array( 'slug' => 'skill_level', 'with_front' => false ),
						'exclude_from_search' => false
					),

					array(
						'id'           => 'recipe_tags',
						'taxonomy'     => 'recipe_tags',
						'plural'       => __( 'Recipe Tags', 'boorecipe' ),
						'single'       => __( 'Recipe Tag', 'boorecipe' ),
						'post_types'   => array( 'boo_recipe' ),
						'hierarchical' => false,
						'rewrite'      => array( 'slug' => 'recipe_tags', 'with_front' => false )

					),

				) ),
			),


		) );

		foreach ( $post_types_fields as $fields ) {

			$this->register_single_post_type( apply_filters( 'boorecipe_post_type_args_before_register', $fields ) );

		}

		do_action( 'boorecipe_post_type_create' );

		$recipe_add_image_sizes_array = apply_filters( 'boorecipe_recipe_add_image_sizes_array', array(
			'recipe_image'                     => array(
				'name'   => 'recipe_image',
				'width'  => 1024,
				'height' => 576,
				'crop'   => true
			),
			'recipe_landscape_image'           => array(
				'name'   => 'recipe_landscape_image',
				'width'  => 768,
				'height' => 500,
				'crop'   => true
			),
			'recipe_landscape_image_thumbnail' => array(
				'name'   => 'recipe_landscape_image_thumbnail',
				'width'  => 150,
				'height' => 100,
				'crop'   => true
			),
		) );


		foreach ( $recipe_add_image_sizes_array as $image_size_args ) {
			add_image_size(
				$image_size_args['name'],
				$image_size_args['width'],
				$image_size_args['height'],
				$image_size_args['crop']
			);
		}

	}

	/**
	 * Register custom post type
	 *
	 * @param array post_type_register_args
	 *
	 * @link https://codex.wordpress.org/Function_Reference/register_post_type
	 */
	private function register_single_post_type( $fields ) {

		/**
		 * Labels used when displaying the posts in the admin and sometimes on the front end.  These
		 * labels do not cover post updated, error, and related messages.  You'll need to filter the
		 * 'post_updated_messages' hook to customize those.
		 */
		$labels = array(
			'name'                  => $fields['plural'],
			'singular_name'         => $fields['singular'],
			'menu_name'             => $fields['menu_name'],
			'new_item'              => sprintf( __( 'New %s', 'boorecipe' ), $fields['singular'] ),
			'add_new_item'          => sprintf( __( 'Add new %s', 'boorecipe' ), $fields['singular'] ),
			'edit_item'             => sprintf( __( 'Edit %s', 'boorecipe' ), $fields['singular'] ),
			'view_item'             => sprintf( __( 'View %s', 'boorecipe' ), $fields['singular'] ),
			'view_items'            => sprintf( __( 'View %s', 'boorecipe' ), $fields['plural'] ),
			'search_items'          => sprintf( __( 'Search %s', 'boorecipe' ), $fields['plural'] ),
			'not_found'             => sprintf( __( 'No %s found', 'boorecipe' ), strtolower( $fields['plural'] ) ),
			'not_found_in_trash'    => sprintf( __( 'No %s found in trash', 'boorecipe' ), strtolower( $fields['plural'] ) ),
			'all_items'             => sprintf( __( 'All %s', 'boorecipe' ), $fields['plural'] ),
			'archives'              => sprintf( __( '%s Archives', 'boorecipe' ), $fields['singular'] ),
			'attributes'            => sprintf( __( '%s Attributes', 'boorecipe' ), $fields['singular'] ),
			'insert_into_item'      => sprintf( __( 'Insert into %s', 'boorecipe' ), strtolower( $fields['singular'] ) ),
			'uploaded_to_this_item' => sprintf( __( 'Uploaded to this %s', 'boorecipe' ), strtolower( $fields['singular'] ) ),

			/* Labels for hierarchical post types only. */
			'parent_item'           => sprintf( __( 'Parent %s', 'boorecipe' ), $fields['singular'] ),
			'parent_item_colon'     => sprintf( __( 'Parent %s:', 'boorecipe' ), $fields['singular'] ),

			/* Custom archive label.  Must filter 'post_type_archive_title' to use. */
			'archive_title'         => $fields['plural'],
		);

		$args = array(
			'labels'              => $labels,
			'description'         => ( isset( $fields['description'] ) ) ? $fields['description'] : '',
			'public'              => ( isset( $fields['public'] ) ) ? $fields['public'] : true,
			'publicly_queryable'  => ( isset( $fields['publicly_queryable'] ) ) ? $fields['publicly_queryable'] : true,
			'exclude_from_search' => ( isset( $fields['exclude_from_search'] ) ) ? $fields['exclude_from_search'] : false,
			'show_ui'             => ( isset( $fields['show_ui'] ) ) ? $fields['show_ui'] : true,
			'show_in_menu'        => ( isset( $fields['show_in_menu'] ) ) ? $fields['show_in_menu'] : true,
			'query_var'           => ( isset( $fields['query_var'] ) ) ? $fields['query_var'] : true,
			'show_in_admin_bar'   => ( isset( $fields['show_in_admin_bar'] ) ) ? $fields['show_in_admin_bar'] : true,
			'capability_type'     => ( isset( $fields['capability_type'] ) ) ? $fields['capability_type'] : 'post',
			'has_archive'         => ( isset( $fields['has_archive'] ) ) ? $fields['has_archive'] : true,
			'hierarchical'        => ( isset( $fields['hierarchical'] ) ) ? $fields['hierarchical'] : true,
			'supports'            => ( isset( $fields['supports'] ) ) ? $fields['supports'] : array(
				'title',
				'editor',
				'excerpt',
				'author',
				'thumbnail',
				'comments',
				'trackbacks',
				'custom-fields',
				'revisions',
				'page-attributes',
				'post-formats',
			),
			'menu_position'       => ( isset( $fields['menu_position'] ) ) ? $fields['menu_position'] : 21,
			'menu_icon'           => ( isset( $fields['menu_icon'] ) ) ? $fields['menu_icon'] : 'dashicons-admin-generic',
			'show_in_nav_menus'   => ( isset( $fields['show_in_nav_menus'] ) ) ? $fields['show_in_nav_menus'] : true,
		);

		if ( isset( $fields['rewrite'] ) ) {

			/**
			 *  Add $this->plugin_name as translatable in the permalink structure,
			 *  to avoid conflicts with other plugins which may use customers as well.
			 */
			$args['rewrite'] = $fields['rewrite'];
		}

		if ( $fields['custom_caps'] ) {

			/**
			 * Provides more precise control over the capabilities than the defaults.  By default, WordPress
			 * will use the 'capability_type' argument to build these capabilities.  More often than not,
			 * this results in many extra capabilities that you probably don't need.  The following is how
			 * I set up capabilities for many post types, which only uses three basic capabilities you need
			 * to assign to roles: 'manage_examples', 'edit_examples', 'create_examples'.  Each post type
			 * is unique though, so you'll want to adjust it to fit your needs.
			 *
			 * @link https://gist.github.com/creativembers/6577149
			 * @link http://justintadlock.com/archives/2010/07/10/meta-capabilities-for-custom-post-types
			 */
			$args['capabilities'] = array(

				// Meta capabilities
				'edit_post'              => 'edit_' . strtolower( $fields['singular'] ),
				'read_post'              => 'read_' . strtolower( $fields['singular'] ),
				'delete_post'            => 'delete_' . strtolower( $fields['singular'] ),

				// Primitive capabilities used outside of map_meta_cap():
				'edit_posts'             => 'edit_' . strtolower( $fields['plural'] ),
				'edit_others_posts'      => 'edit_others_' . strtolower( $fields['plural'] ),
				'publish_posts'          => 'publish_' . strtolower( $fields['plural'] ),
				'read_private_posts'     => 'read_private_' . strtolower( $fields['plural'] ),

				// Primitive capabilities used within map_meta_cap():
				'delete_posts'           => 'delete_' . strtolower( $fields['plural'] ),
				'delete_private_posts'   => 'delete_private_' . strtolower( $fields['plural'] ),
				'delete_published_posts' => 'delete_published_' . strtolower( $fields['plural'] ),
				'delete_others_posts'    => 'delete_others_' . strtolower( $fields['plural'] ),
				'edit_private_posts'     => 'edit_private_' . strtolower( $fields['plural'] ),
				'edit_published_posts'   => 'edit_published_' . strtolower( $fields['plural'] ),
				'create_posts'           => 'edit_' . strtolower( $fields['plural'] )

			);

			/**
			 * Adding map_meta_cap will map the meta correctly.
			 * @link https://wordpress.stackexchange.com/questions/108338/capabilities-and-custom-post-types/108375#108375
			 */
			$args['map_meta_cap'] = true;

			/**
			 * Assign capabilities to users
			 * Without this, users - also admins - can not see post type.
			 */
			$this->assign_capabilities( $args['capabilities'], $fields['custom_caps_users'] );
		}

		register_post_type( $fields['slug'], $args );

		/**
		 * Register Taxnonmies if any
		 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
		 */
		if ( isset( $fields['taxonomies'] ) && is_array( $fields['taxonomies'] ) ) {

			foreach ( $fields['taxonomies'] as $taxonomy ) {

				$this->register_single_post_type_taxonomy( $taxonomy );

			}

		}

	}

	/**
	 * Assign capabilities to users
	 *
	 * @param $caps_map
	 * @param $users
	 *
	 * @link https://codex.wordpress.org/Function_Reference/register_post_type
	 * @link https://typerocket.com/ultimate-guide-to-custom-post-types-in-wordpress/
	 */
	public function assign_capabilities( $caps_map, $users ) {

		foreach ( $users as $user ) {

			$user_role = get_role( $user );

			foreach ( $caps_map as $cap_map_key => $capability ) {

				$user_role->add_cap( $capability );

			}

		}

	}

	/**
	 * @param $tax_fields
	 *
	 * This function is responsible to add the post title to the meta key, so that we can do the search including title
	 */
	public function register_single_post_type_taxonomy( $tax_fields ) {

		$labels = array(
			'name'                       => $tax_fields['plural'],
			'singular_name'              => $tax_fields['single'],
			'menu_name'                  => $tax_fields['plural'],
			'all_items'                  => sprintf( __( 'All %s', 'boorecipe' ), $tax_fields['plural'] ),
			'edit_item'                  => sprintf( __( 'Edit %s', 'boorecipe' ), $tax_fields['single'] ),
			'view_item'                  => sprintf( __( 'View %s', 'boorecipe' ), $tax_fields['single'] ),
			'update_item'                => sprintf( __( 'Update %s', 'boorecipe' ), $tax_fields['single'] ),
			'add_new_item'               => sprintf( __( 'Add New %s', 'boorecipe' ), $tax_fields['single'] ),
			'new_item_name'              => sprintf( __( 'New %s Name', 'boorecipe' ), $tax_fields['single'] ),
			'parent_item'                => sprintf( __( 'Parent %s', 'boorecipe' ), $tax_fields['single'] ),
			'parent_item_colon'          => sprintf( __( 'Parent %s:', 'boorecipe' ), $tax_fields['single'] ),
			'search_items'               => sprintf( __( 'Search %s', 'boorecipe' ), $tax_fields['plural'] ),
			'popular_items'              => sprintf( __( 'Popular %s', 'boorecipe' ), $tax_fields['plural'] ),
			'separate_items_with_commas' => sprintf( __( 'Separate %s with commas', 'boorecipe' ), $tax_fields['plural'] ),
			'add_or_remove_items'        => sprintf( __( 'Add or remove %s', 'boorecipe' ), $tax_fields['plural'] ),
			'choose_from_most_used'      => sprintf( __( 'Choose from the most used %s', 'boorecipe' ), $tax_fields['plural'] ),
			'not_found'                  => sprintf( __( 'No %s found', 'boorecipe' ), $tax_fields['plural'] ),
		);

		$args = array(
			'label'                 => $tax_fields['plural'],
			'labels'                => $labels,
			'hierarchical'          => ( isset( $tax_fields['hierarchical'] ) ) ? $tax_fields['hierarchical'] : true,
			'public'                => ( isset( $tax_fields['public'] ) ) ? $tax_fields['public'] : true,
			'show_ui'               => ( isset( $tax_fields['show_ui'] ) ) ? $tax_fields['show_ui'] : true,
			'show_in_nav_menus'     => ( isset( $tax_fields['show_in_nav_menus'] ) ) ? $tax_fields['show_in_nav_menus'] : true,
			'show_tagcloud'         => ( isset( $tax_fields['show_tagcloud'] ) ) ? $tax_fields['show_tagcloud'] : true,
			'meta_box_cb'           => ( isset( $tax_fields['meta_box_cb'] ) ) ? $tax_fields['meta_box_cb'] : null,
			'show_admin_column'     => ( isset( $tax_fields['show_admin_column'] ) ) ? $tax_fields['show_admin_column'] : true,
			'show_in_quick_edit'    => ( isset( $tax_fields['show_in_quick_edit'] ) ) ? $tax_fields['show_in_quick_edit'] : true,
			'update_count_callback' => ( isset( $tax_fields['update_count_callback'] ) ) ? $tax_fields['update_count_callback'] : '',
			'show_in_rest'          => ( isset( $tax_fields['show_in_rest'] ) ) ? $tax_fields['show_in_rest'] : true,
			'rest_base'             => $tax_fields['taxonomy'],
			'rest_controller_class' => ( isset( $tax_fields['rest_controller_class'] ) ) ? $tax_fields['rest_controller_class'] : 'WP_REST_Terms_Controller',
			'query_var'             => $tax_fields['taxonomy'],
			'rewrite'               => ( isset( $tax_fields['rewrite'] ) ) ? $tax_fields['rewrite'] : true,
			'sort'                  => ( isset( $tax_fields['sort'] ) ) ? $tax_fields['sort'] : '',
		);

		$args = apply_filters( $tax_fields['taxonomy'] . '_args', $args );

		register_taxonomy( $tax_fields['taxonomy'], $tax_fields['post_types'], $args );

	}

	/**
	 * @param $option_id
	 *
	 * @return mixed
	 */
	public function get_options_value( $option_id ) {
		return Boorecipe_Globals::get_options_value( $option_id );
	}

	/**
	 *  Create Recipe Meta Box
	 */
	public function create_meta_box() {

		global $post;

		$prefix = Boorecipe_Globals::get_meta_prefix();

		$this->meta_id = 'boorecipe-recipe-meta';

		$config_recipe_metabox = apply_filters( 'boorecipe_config_recipe_metabox', array(

			/*
			* METABOX
			*/
			'type'       => 'metabox',                       // Required, menu or metabox
			'id'         => $this->meta_id,    // Required, meta box id, unique, for saving meta: id[field-id]
			'post_types' => array( 'boo_recipe' ),         // Post types to display meta box
			'context'    => 'normal',
			'priority'   => 'high',
			'title'      => __( 'Recipe Schema Options', 'boorecipe' ),                 // The name of this page
			'capability' => 'edit_posts',                    // The capability needed to view the page
			'tabbed'     => true,
			'multilang'  => true,
			'options'    => 'simple'

		) );


		$recipe_meta_fields[] = array(

			'id'     => 'recipe-meta-primary',
			'name'   => 'recipe-meta-primary',
			'title'  => __( 'Primary Information', 'boorecipe' ),
			'icon'   => 'dashicons-carrot',
			'tabbed' => true,
			'fields' => apply_filters( 'boorecipe_recipe_metabox_fields', array(

				array(
					'id'       => $prefix . 'short_description',
					'type'     => 'editor',
					'title'    => __( 'Short Description', 'boorecipe' ),
					'after'    => __( 'Describe your recipe in a few words', 'boorecipe' ),
					'teeny'    => true,
					'sanitize' => 'wp_kses_post'
				),

				array(
					'id'       => $prefix . 'recipe_time_format',
					'type'     => 'radio',
					'title'    => __( 'Time Format', 'boorecipe' ),
					'options'  => array(
						'time_format_minutes' => __( 'Minutes', 'boorecipe' ),
						'time_format_hours'   => __( 'Hours', 'boorecipe' ),
					),
					'default'  => 'time_format_minutes',
					'style'    => 'fancy',
					'sanitize' => 'sanitize_text_field'

				),

				array(
					'id'         => $prefix . 'prep_time',
					'type'       => 'number',
					'title'      => __( 'Prep Time', 'boorecipe' ),
					'after'      => ' <i class="text-muted">' .
					                __( 'Hours or Minutes depending upon the options selected above', 'boorecipe' )
					                . '</i>',
					'attributes' => array(
						'class' => 'recipe_prep_time',
					),
					'sanitize'   => 'boorecipe_sanitize_int'

				),

				array(
					'id'         => $prefix . 'cook_time',
					'type'       => 'number',
					'title'      => __( 'Cook Time', 'boorecipe' ),
					'after'      => ' <i class="text-muted">' .
					                __( 'Hours or Minutes depending upon the options selected above', 'boorecipe' )
					                . '</i>',
					'attributes' => array(
						'class' => 'recipe_cook_time',
					),
					'sanitize'   => 'boorecipe_sanitize_int'

				),
				array(
					'id'         => $prefix . 'total_time',
					'type'       => 'number',
					'title'      => __( 'Total Time', 'boorecipe' ),
					'after'      => ' <i class="text-muted">' .
					                __( 'Hours or Minutes depending upon the options selected above', 'boorecipe' )
					                . '</i>',
					'attributes' => array(
						'class' => 'recipe_total_time',
					),
					'sanitize'   => 'boorecipe_sanitize_int'
				),


				array(
					'id'          => $prefix . 'yields',
					'type'        => 'text',
					'title'       => __( 'Yields', 'boorecipe' ),
					'description' => __( 'e.g. 6 bowls, 2 cakes, three ice-creams', 'boorecipe' ),
					'attributes'  => array(
						'placeholder' => __( 'Text input expected', 'boorecipe' ),
					),
					'sanitize'    => 'sanitize_text_field'
				),

				array(
					'id'       => $prefix . 'is_external_author',
					'type'     => 'checkbox',
					'title'    => __( 'Is External Author?', 'boorecipe' ),
					'label'    => __( 'Check this box if the recipe author is not a registered user on this site', 'boorecipe' ),
					'style'    => 'fancy',
					'sanitize' => 'sanitize_text_field'
				),


				array(
					'id'         => $prefix . 'external_author_name',
					'type'       => 'text',
					'title'      => __( 'External author name', 'boorecipe' ),
					'dependency' => array( 'is_external_author', '==', 'true' ),
					'attributes' => array(
						'placeholder' => __( 'External author name', 'boorecipe' ),
					),
					'sanitize'   => 'sanitize_text_field'
				),

				array(
					'id'         => $prefix . 'external_author_link',
					'type'       => 'text',
					'title'      => __( 'External author link', 'boorecipe' ),
					'dependency' => array( 'is_external_author', '==', 'true' ),
					'attributes' => array(
						'placeholder' => __( 'External author link', 'boorecipe' ),
					),
					'sanitize'   => 'esc_url_raw'
				),

				array(
					'id'          => $prefix . 'ingredients',
					'type'        => 'textarea',
					'title'       => __( 'Ingredients', 'boorecipe' ),
					'description' => __( 'If you need to add ingredient group, place ** before the group heading like: <br/> **Cake<br/>ingredient 1<br/>ingredient 2  ', 'boorecipe' ),
					'after'       => __( 'One ingredient per line.', 'boorecipe' ),
					'sanitize'    => 'wp_kses_post'
				),

				array(
					'id'          => $prefix . 'directions',
					'type'        => 'textarea',
					'title'       => __( 'Directions', 'boorecipe' ),
					'description' => __( 'If you need to add directions group, place ** before the group heading like: <br/> **How to Make Crust<br/>Direction 1<br/>Direction 2', 'boorecipe' ),
					'after'       => __( 'One Step per line', 'boorecipe' ),
					'sanitize'    => 'wp_kses_post'
				),

				array(
					'id'          => $prefix . 'list_excerpt',
					'type'        => 'textarea',
					'title'       => __( 'Excerpt for List view', 'boorecipe' ),
					'description' => __( 'This will show in archive view of recipes', 'boorecipe' ),
					'sanitize'    => 'wp_kses_post'
				),

				array(
					'id'       => $prefix . 'additional_notes',
					'type'     => 'editor',
					'title'    => __( 'Additional Notes', 'boorecipe' ),
					'after'    => __( 'Add additional notes to the recipe. it will show at the end of recipe', 'boorecipe' ),
					'teeny'    => true,
					'sanitize' => 'wp_kses_post'
				),

				array(
					'id'       => $prefix . 'recipe_title',
					'type'     => 'hidden',
					'sanitize' => 'sanitize_title'
				),


			) )
		);


		// initialize array for nutrition fields
		$recipe_meta_nutrition_fields = array();

		// Check if the user want to show nutrition info
		$recipe_meta_nutrition_fields[] = array(
			'id'       => $prefix . 'show_nutrition',
			'type'     => 'switcher',
			'title'    => __( 'Show Nutrition', 'boorecipe' ),
			'label'    => __( 'Do you want to show nutrition info for this recipe? Its required by Schema.org', 'boorecipe' ),
			'default'  => 'yes',
			'sanitize' => 'sanitize_key'
		);


		// Get nutrition meta to populate in foreach
		$nutrition_meta = boorecipe_get_nutrition_meta();

//		update $recipe_meta_nutrition_fields with the help of nutrition meta

		if ( is_array( $nutrition_meta ) ):
			foreach ( $nutrition_meta as $key => $nutrition ) {

				$itemprop    = $nutrition['itemprop'];
				$display     = $nutrition['display'];
				$description = $nutrition['description'];
				$measurement = ! empty( $nutrition['measurement'] ) ? $nutrition['measurement'] : '';

				switch ( $measurement ) {
					case 'g':
						$measurement = __( 'in grams', 'boorecipe' );
						break;

					case 'mg':
						$measurement = __( 'in milligrams', 'boorecipe' );
						break;

					default:
						$measurement = __( 'Text input expected', 'boorecipe' );
				}

				// Using the right sanitization function
				switch ( $itemprop ) {

					case 'servingSize':
						$recipe_meta_nutrition_fields[] = array(
							'id'          => $prefix . $itemprop,
							'type'        => 'text',
							'title'       => $display,
							'description' => $description,
							'dependency'  => array( 'show_nutrition', '==', true ),
							'attributes'  => array(
								'placeholder' => $measurement,
							),
							'sanitize'    => 'sanitize_text_field'
						);

						break;

					default:
						$recipe_meta_nutrition_fields[] = array(
							'id'          => $prefix . $itemprop,
							'type'        => 'text',
							'title'       => $display,
							'description' => $description,
							'attributes'  => array(
								'placeholder' => $measurement,
							),
							'dependency'  => array( 'show_nutrition', '==', true ),
							'sanitize'    => 'boorecipe_sanitize_float'
						);

				}


			} //End foreach
		endif; //is_array( $nutrition_meta)

		$recipe_meta_fields[] = array(
			'id'     => 'recipe-meta-nutrition',
			'name'   => 'recipe-meta-nutrition',
			'title'  => __( 'Nutrition', 'boorecipe' ),
			'icon'   => 'dashicons-portfolio',
//			'dependency' => array( 'serving_size_switcher', '==', true ),
			'fields' => $recipe_meta_nutrition_fields,

		);

		new Exopite_Simple_Options_Framework( $config_recipe_metabox, apply_filters( 'boorecipe_recipe_post_type_meta_fields', $recipe_meta_fields ) );


	}

	/**
	 * @param $post_id
	 * @param $post
	 * @param $update
	 */
	public function update_contents_of_post_with_title( $post_id, $post, $update ) {


		$recipe_meta = get_post_meta( $post->ID, $this->meta_id, true );


		if ( ! empty( $recipe_meta ) && is_array( $recipe_meta ) ) {

			$recipe_meta['recipe_title'] = get_the_title( $post_id );

			update_post_meta( $post_id, $this->meta_id, $recipe_meta );

		}

	}

} // class
