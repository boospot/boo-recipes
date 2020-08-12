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

	protected $prefix;
	/**
	 * @var : it will be the id used for $meta
	 */
	private $meta_id;

	public function __construct() {
		$this->prefix = Boorecipe_Globals::get_meta_prefix();
	}

	/**
	 * Create post types
	 */
	public function create_custom_post_type() {

		/**
		 * This is not all the fields, only what I find important. Feel free to change this function ;)
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_post_type
		 */

		$recipe_slug = ( ! empty( $this->get_options_value( 'recipe_slug' ) ) )
			? sanitize_key( $this->get_options_value( 'recipe_slug' ) )
			: 'recipe';

		$recipe_category_slug = ( ! empty( $this->get_options_value( 'recipe_category_slug' ) ) )
			? sanitize_key( $this->get_options_value( 'recipe_category_slug' ) )
			: 'recipe-category';

		$skill_level_slug = ( ! empty( $this->get_options_value( 'skill_level_slug' ) ) )
			? sanitize_key( $this->get_options_value( 'skill_level_slug' ) )
			: 'skill-level';

		$recipe_tags_slug = ( ! empty( $this->get_options_value( 'recipe_tags_slug' ) ) )
			? sanitize_key( $this->get_options_value( 'recipe_tags_slug' ) )
			: 'recipe-tags';

		$post_types_fields = apply_filters( 'boorecipe_post_type_create_args', array(

			array(
				'slug'                => 'boo_recipe',
				'singular'            => __( 'Recipe', 'boo-recipes' ),
				'plural'              => __( 'Recipes', 'boo-recipes' ),
				'menu_name'           => __( 'Recipes', 'boo-recipes' ),
				'description'         => __( 'Recipes', 'boo-recipes' ),
				'has_archive'         => true,
				'hierarchical'        => false,
				'menu_icon'           => 'dashicons-carrot',
				'rewrite'             => array(
					'slug'       => $recipe_slug,
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
//					'trackbacks',
//					'custom-fields',
					'revisions',
					'page-attributes',
				),
				'custom_caps'         => false,
//				'custom_caps_users'   => array(
//					'administrator',
//				),
				'taxonomies'          => apply_filters( 'boorecipe_taxonomies_create_args', array(

					array(
						'id'                  => 'recipe_category',
						'taxonomy'            => 'recipe_category',
						'plural'              => __( 'Recipe Categories', 'boo-recipes' ),
						'single'              => __( 'Recipe Category', 'boo-recipes' ),
						'post_types'          => array( 'boo_recipe' ),
						'rewrite'             => array( 'slug' => $recipe_category_slug, 'with_front' => false ),
						'exclude_from_search' => false
					),

					array(
						'id'                  => 'skill_level',
						'taxonomy'            => 'skill_level',
						'plural'              => __( 'Skill Levels', 'boo-recipes' ),
						'single'              => __( 'Skill Level', 'boo-recipes' ),
						'post_types'          => array( 'boo_recipe' ),
						'rewrite'             => array( 'slug' => $skill_level_slug, 'with_front' => false ),
						'exclude_from_search' => false
					),

					array(
						'id'           => 'recipe_tags',
						'taxonomy'     => 'recipe_tags',
						'plural'       => __( 'Recipe Tags', 'boo-recipes' ),
						'single'       => __( 'Recipe Tag', 'boo-recipes' ),
						'post_types'   => array( 'boo_recipe' ),
						'hierarchical' => false,
						'rewrite'      => array( 'slug' => $recipe_tags_slug, 'with_front' => false )
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
			'recipe_landscape_image_archive'   => array(
				'name'   => 'recipe_landscape_image_archive',
				'width'  => 350,
				'height' => 300,
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
	 * @param $option_id
	 *
	 * @return mixed
	 */
	public function get_options_value( $option_id ) {
		return Boorecipe_Globals::get_options_value( $option_id );
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
			'new_item'              => sprintf( __( 'New %s', 'boo-recipes' ), $fields['singular'] ),
			'add_new_item'          => sprintf( __( 'Add new %s', 'boo-recipes' ), $fields['singular'] ),
			'edit_item'             => sprintf( __( 'Edit %s', 'boo-recipes' ), $fields['singular'] ),
			'view_item'             => sprintf( __( 'View %s', 'boo-recipes' ), $fields['singular'] ),
			'view_items'            => sprintf( __( 'View %s', 'boo-recipes' ), $fields['plural'] ),
			'search_items'          => sprintf( __( 'Search %s', 'boo-recipes' ), $fields['plural'] ),
			'not_found'             => sprintf( __( 'No %s found', 'boo-recipes' ), strtolower( $fields['plural'] ) ),
			'not_found_in_trash'    => sprintf( __( 'No %s found in trash', 'boo-recipes' ), strtolower( $fields['plural'] ) ),
			'all_items'             => sprintf( __( 'All %s', 'boo-recipes' ), $fields['plural'] ),
			'archives'              => sprintf( __( '%s Archives', 'boo-recipes' ), $fields['singular'] ),
			'attributes'            => sprintf( __( '%s Attributes', 'boo-recipes' ), $fields['singular'] ),
			'insert_into_item'      => sprintf( __( 'Insert into %s', 'boo-recipes' ), strtolower( $fields['singular'] ) ),
			'uploaded_to_this_item' => sprintf( __( 'Uploaded to this %s', 'boo-recipes' ), strtolower( $fields['singular'] ) ),

			/* Labels for hierarchical post types only. */
			'parent_item'           => sprintf( __( 'Parent %s', 'boo-recipes' ), $fields['singular'] ),
			'parent_item_colon'     => sprintf( __( 'Parent %s:', 'boo-recipes' ), $fields['singular'] ),

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
//				'custom-fields',
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
			'all_items'                  => sprintf( __( 'All %s', 'boo-recipes' ), $tax_fields['plural'] ),
			'edit_item'                  => sprintf( __( 'Edit %s', 'boo-recipes' ), $tax_fields['single'] ),
			'view_item'                  => sprintf( __( 'View %s', 'boo-recipes' ), $tax_fields['single'] ),
			'update_item'                => sprintf( __( 'Update %s', 'boo-recipes' ), $tax_fields['single'] ),
			'add_new_item'               => sprintf( __( 'Add New %s', 'boo-recipes' ), $tax_fields['single'] ),
			'new_item_name'              => sprintf( __( 'New %s Name', 'boo-recipes' ), $tax_fields['single'] ),
			'parent_item'                => sprintf( __( 'Parent %s', 'boo-recipes' ), $tax_fields['single'] ),
			'parent_item_colon'          => sprintf( __( 'Parent %s:', 'boo-recipes' ), $tax_fields['single'] ),
			'search_items'               => sprintf( __( 'Search %s', 'boo-recipes' ), $tax_fields['plural'] ),
			'popular_items'              => sprintf( __( 'Popular %s', 'boo-recipes' ), $tax_fields['plural'] ),
			'separate_items_with_commas' => sprintf( __( 'Separate %s with commas', 'boo-recipes' ), $tax_fields['plural'] ),
			'add_or_remove_items'        => sprintf( __( 'Add or remove %s', 'boo-recipes' ), $tax_fields['plural'] ),
			'choose_from_most_used'      => sprintf( __( 'Choose from the most used %s', 'boo-recipes' ), $tax_fields['plural'] ),
			'not_found'                  => sprintf( __( 'No %s found', 'boo-recipes' ), $tax_fields['plural'] ),
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
	 * @return  array configuration for metabox.io metabox array
	 */
	public function register_meta_box_nutrition( $meta_boxes ) {

		$prefix = $this->prefix;

		// Check if the user want to show nutrition info
		$recipe_meta_nutrition_fields[] = array(
			'id'                => $prefix . 'show_nutrition',
			'type'              => 'switch',
			'name'              => __( 'Show Nutrition', 'boo-recipes' ),
			'desc'              => __( 'Do you want to show nutrition info for this recipe? Its required by Schema.org', 'boo-recipes' ),
			'std'               => 1,
			'sanitize_callback' => 'sanitize_key'

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
						$measurement = __( 'in grams', 'boo-recipes' );
						break;

					case 'mg':
						$measurement = __( 'in milligrams', 'boo-recipes' );
						break;

					default:
						$measurement = __( 'Text input expected', 'boo-recipes' );
				}

				// Using the right sanitization function
				switch ( $itemprop ) {

					case 'servingSize':
						$recipe_meta_nutrition_fields[] = array(
							'id'          => $prefix . $itemprop,
							'type'        => 'text',
							'name'        => $display,
							'desc'        => $description,
							'visible'     => array( $prefix . 'show_nutrition', '=', 1 ),
							'placeholder' => $measurement,

							'sanitize' => 'sanitize_text_field'
						);

						break;

					default:
						$recipe_meta_nutrition_fields[] = array(
							'id'          => $prefix . $itemprop,
							'type'        => 'number',
							'name'        => $display,
							'desc'        => $description,
							'placeholder' => $measurement,
							'visible'     => array( $prefix . 'show_nutrition', '=', 1 ),
							'step'        => 'any',
//							'sanitize_callback' => 'boorecipe_sanitize_float'
						);

				}


			} //End foreach
		endif; //is_array( $nutrition_meta)

		$nutrition_meta_box_array = array(
			'id'         => 'boorecipe-recipe-meta-nutrition',
			'title'      => esc_html__( 'Nutrition', 'boo-recipes' ),
			'post_types' => array( 'boo_recipe' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'autosave'   => 'false',
//			'style'      => 'seamless',
			'fields'     => $recipe_meta_nutrition_fields,


		);

//		$recipe_meta_fields = apply_filters( 'boorecipe_recipe_post_type_meta_fields', $recipe_meta_fields );
		Boorecipe_Globals::set_meta_fields( $recipe_meta_nutrition_fields );

		$meta_boxes[] = $nutrition_meta_box_array;

		return $meta_boxes;
	}

	/**
	 *
	 */
	public function register_meta_box_primary( $meta_boxes ) {


		$prefix = $this->prefix;

		$enable_wysiwyg_editor = $this->get_options_value( 'enable_wysiwyg_editor' );

		$editor_type = ( 'yes' === $enable_wysiwyg_editor ) ? 'wysiwyg' : 'textarea';

		$recipe_primary_fields = apply_filters( 'boorecipe_recipe_metabox_fields', array(
			array(
				'id'      => $prefix . 'short_description',
				'name'    => esc_html__( 'Short Description', 'boo-recipes' ),
				'type'    => $editor_type,
				'desc'    => esc_html__( 'Describe your recipe in a few words', 'boo-recipes' ),
				'rows'    => 5,
				'options' => array(
					'textarea_rows' => 5
				)

			),
			array(
				'id'      => $prefix . 'recipe_time_format',
				'name'    => esc_html__( 'Time Format', 'boo-recipes' ),
				'type'    => 'radio',
				'options' => array(
					'time_format_minutes' => esc_html__( 'Minutes', 'boo-recipes' ),
					'time_format_hours'   => esc_html__( 'Hours', 'boo-recipes' ),
				),
				'inline'  => 'true',
				'std'     => 'time_format_minutes',
			),
			array(
				'id'    => $prefix . 'prep_time',
				'type'  => 'number',
				'name'  => esc_html__( 'Prep Time', 'boo-recipes' ),
				'desc'  => esc_html__( 'Hours or Minutes depending upon the options selected above', 'boo-recipes' ),
				'class' => 'recipe_prep_time',
			),
			array(
				'id'    => $prefix . 'cook_time',
				'name'  => esc_html__( 'Cook Time', 'boo-recipes' ),
				'type'  => 'time',
				'desc'  => esc_html__( 'Format is HH:MM', 'boo-recipes' ),
				'class' => 'recipe_cook_time',
			),
			array(
				'id'    => $prefix . 'total_time',
				'name'  => esc_html__( 'Total Time', 'boo-recipes' ),
				'type'  => 'time',
				'desc'  => esc_html__( 'Hours or Minutes depending upon the options selected above', 'boo-recipes' ),
				'class' => 'recipe_total_time',
			),
			array(
				'id'          => $prefix . 'yields',
				'type'        => 'text',
				'name'        => esc_html__( 'Yields', 'boo-recipes' ),
				'desc'        => esc_html__( 'e.g. 6 bowls, 2 cakes, three ice-creams', 'boo-recipes' ),
				'placeholder' => esc_html__( 'Text input expected', 'boo-recipes' ),
			),
			array(
				'id'   => $prefix . 'is_external_author',
				'name' => esc_html__( 'Is External Author?', 'boo-recipes' ),
				'type' => 'switch',
				'desc' => esc_html__( 'Check this box if the recipe author is not a registered user on this site', 'boo-recipes' ),
			),
			array(
				'id'          => $prefix . 'external_author_name',
				'type'        => 'text',
				'name'        => esc_html__( 'External author name', 'boo-recipes' ),
				'std'         => 'small',
				'placeholder' => esc_html__( 'External author name', 'boo-recipes' ),
				'visible'     => array( "{$prefix}is_external_author", '=', 1 ),
			),
			array(
				'id'          => $prefix . 'external_author_link',
				'type'        => 'url',
				'name'        => esc_html__( 'External author link', 'boo-recipes' ),
				'placeholder' => esc_html__( 'External author link', 'boo-recipes' ),
				'visible'     => array( "{$prefix}is_external_author", '=', 1 ),
			),
			array(
				'id'          => $prefix . 'ingredients',
				'type'        => 'textarea',
				'name'        => esc_html__( 'Ingredients', 'boo-recipes' ),
				'desc'        => __( 'If you need to add ingredient group, place ** before the group heading like: **Cakeingredient 1ingredient 2', 'boo-recipes' ),
				'placeholder' => esc_html__( 'One ingredient per line.', 'boo-recipes' ),
				'rows'        => 8,
				'visible'     => array( $prefix . 'ingredients_type', 'not in', array( 'wysiwyg' ) ),
			),
			array(
				'id'          => $prefix . 'directions',
				'type'        => 'textarea',
				'name'        => esc_html__( 'Directions', 'boo-recipes' ),
				'desc'        => __( 'If you need to add directions group, place ** before the group heading like: <br/> **How to Make Crust<br/>Direction 1<br/>Direction 2', 'boo-recipes' ),
				'placeholder' => esc_html__( 'One Step per line', 'boo-recipes' ),
				'rows'        => 8,
				'visible'     => array( $prefix . 'directions_type', 'not in', array( 'wysiwyg' ) ),
			),
			array(
				'id'   => $prefix . 'list_excerpt',
				'type' => 'textarea',
				'name' => esc_html__( 'Excerpt for List view', 'boo-recipes' ),
				'desc' => __( 'This will show in archive view of recipes', 'boo-recipes' ),
				'rows' => 4,
			),
			array(
				'id'      => $prefix . 'additional_notes',
				'type'    => $editor_type,
				'name'    => esc_html__( 'Additional Notes', 'boo-recipes' ),
				'desc'    => esc_html__( 'Add additional notes to the recipe. it will show at the end of recipe', 'boo-recipes' ),
				'rows'    => 5,
				'options' => array(
					'textarea_rows' => 5
				)
			),
		) );

		$primary_metabox_array = array(
			'id'         => 'boorecipe-recipe-meta-primary',
			'title'      => esc_html__( 'Recipe Schema Information', 'boo-recipes' ),
			'post_types' => array( 'boo_recipe' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'autosave'   => 'false',
//			'style'      => 'seamless',
			'fields'     => $recipe_primary_fields,
		);

		Boorecipe_Globals::set_meta_fields( $recipe_primary_fields );

		$meta_boxes[] = $primary_metabox_array;

		return $meta_boxes;

	}

	/**
	 * @param $post_id
	 * @param $post
	 * @param $update
	 */
	public function update_contents_of_post_with_title( $post_id, $post, $update ) {

		update_post_meta( $post_id, $this->prefix . 'recipe_title', get_the_title( $post_id ) );

	}

} // class
