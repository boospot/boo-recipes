<?php /** @noinspection CheckEmptyScriptTag */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Globals' ) ) {
	return;
}

/**
 * Class Boorecipe_Globals
 * Defining Global Utility Functions
 */
class Boorecipe_Globals {

	public static $default_language_code;
	public static $current_language_code;
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private static $plugin_name;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private static $version;
	/**
	 * The Plugin Options
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var
	 */
	private static $options;
	/**
	 * The Single Shortcode Option name
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var
	 */
	private static $registered_shortcodes_option_name;

	/**
	 * Boorecipe_Globals constructor.
	 *
	 * @param $plugin_name
	 * @param $version
	 */
	public function __construct( $plugin_name, $version ) {

		self::$plugin_name           = $plugin_name;
		self::$version               = $version;
		self::$current_language_code = mb_substr( get_locale(), 0, 2 );
		self::$default_language_code = self::$current_language_code;

//		self::set_current_language_code();
		self::set_options();

	} // __construct()

	/**
	 * Register recipe elated shortcode
	 * so that we can use this info to load different resources.
	 *
	 * @param $shortcode_tag
	 * @param null $shortcode_type
	 */
	public static function register_shortcode( $shortcode_tag, $shortcode_type = null ) {

//		delete_option( self::$registered_shortcodes_option_name);

		$registered_shortcodes = self::get_registered_shortcodes();

		if ( empty( $registered_shortcodes ) ) {
			$registered_shortcodes = array();
		}

		if ( $shortcode_type != null ):
			$registered_shortcodes[ $shortcode_type ][] = $shortcode_tag;

			$registered_shortcodes[ $shortcode_type ] = array_unique( $registered_shortcodes[ $shortcode_type ] );
//			if ( isset( $registered_shortcodes[ $shortcode_type ] ) ) {
//				// we already have some shortcode for this type
//
//
//			} else {
//				// this is first time for this type
//				$registered_shortcodes[ $shortcode_type ][] = $shortcode_tag;
//			}
//
//			array_unique( $registered_shortcodes[ $shortcode_type ] );

		else :
			$registered_shortcodes[] = $shortcode_tag;
		endif;

		update_option( self::$registered_shortcodes_option_name, $registered_shortcodes );

	}

	/**
	 * Returns the recipe registered shortcodes
	 *
	 * @param null $shortcode_type
	 *
	 * @return array|mixed
	 */
	private static function get_registered_shortcodes( $shortcode_type = null ) {

		$registered_shortcodes = get_option( self::$registered_shortcodes_option_name );

		if ( $shortcode_type === null ) {
			return $registered_shortcodes;
		} else {
			return ( isset( $registered_shortcodes[ $shortcode_type ] ) ) ? $registered_shortcodes[ $shortcode_type ] : array();
		}
	}

	/**
	 * @return bool
	 */
	public static function is_single_recipe() {
		return ( is_singular( 'boo_recipe' ) ) ? true : false;
	}

	/**
	 * @param $option_id
	 *
	 * @return bool|mixed
	 */
	public static function get_options_value( $option_id ) {

		$options_array = self::get_options();

		$options_array = apply_filters( 'boorecipe_options_array_from_db', $options_array );

		$get_options_value = (
			isset( $options_array[ $option_id ] )
			&& ! empty( $options_array[ $option_id ] )
		)
			? $options_array[ $option_id ]
			: self::get_default_options( $option_id );

		return $get_options_value;
	}

	/**
	 * @return mixed
	 */
	public static function get_options() {


//		if ( empty( self::$current_language_code ) ) {
//			self::set_current_language_code();
////			var_dump( self::$current_language_code);
//
//		}


		return isset( self::$options[ self::$current_language_code ] ) ? self::$options[ self::$current_language_code ] : self::$options;
	}

	/**
	 * Sets the private var $options
	 */
	protected static function set_options() {

		// Only set options if not already set
		if ( empty( self::$options ) ) {
			$option_name = self::$plugin_name . '-options';

//			$options_for_all_languages = get_option( $option_name );
//
//			self::set_current_language_code();
//
//			$options_for_current_language = $options_for_all_languages[ self::$current_language_code ];
//
////			var_dump( $options_for_current_language); die();

			self::$options = get_option( $option_name );
		}

		self::$registered_shortcodes_option_name = self::$plugin_name . '-registered-shortcodes';

	}

	/**
	 * @param $key
	 *
	 * @return bool|mixed
	 */
	public static function get_default_options( $key ) {

		$default_options = self::get_default_options_array();

		return isset( $default_options[ $key ] ) ? $default_options[ $key ] : false;
	}

	/**
	 * Plugin Default Options
	 *
	 * @return array
	 */
	public static function get_default_options_array() {


		$default_options = array(
			'time_content_unit_minutes'         => __( 'mins', 'boorecipe' ),
			'time_content_unit_hours'           => __( 'hours', 'boorecipe' ),
			'time_format_minutes'               => __( 'mins', 'boorecipe' ),
			'time_format_hours'                 => __( 'hours', 'boorecipe' ),
			'single_recipe_icon_size'           => 32, // available option: 16 20 24 28 32 36 40 44 48
			'single_recipe_icon_size_2'         => 20, // available option: 16 20 24 28 32 36 40 44 48
			'layout_switcher_icon_size'         => 16, // available option: 16 20 24 28 32 36 40 44 48
			'archive_key_point_icon_size'       => 16, // available option: 16 20 24 28 32 36 40 44 48
			'general_icon_size'                 => 16, // available option: 16 20 24 28 32 36 40 44 48
			'message_nonce_failed'              => __( 'Failed security check', 'boorecipe' ),
			'message_placeholder_keyword_field' => __( 'Enter Keyword Here...', 'boorecipe' ),
			'social_share'                      => _x( 'Share', 'facebook, linkedin etc', 'boorecipe' ),
			'social_save'                       => _x( 'Save', 'pinterest etc', 'boorecipe' ),
			'social_tweet'                      => _x( 'Tweet', 'twitter tweet', 'boorecipe' ),
			'social_email'                      => _x( 'Email', 'Send Email', 'boorecipe' ),
			'recipe_archive_layout'             => 'grid',
			'grid_view_image_size'              => 'recipe_landscape_image',
			'list_view_image_size'              => 'recipe_landscape_image_thumbnail',
			'show_icons'                        => 'yes',
			'show_key_point_label'              => 'yes',
			'heading_for_archive_title'         => 'h3',
			'show_archive_excerpt'              => 'yes',
			'show_archive_key_point_icons'      => 'yes',
			'show_archive_key_point_labels'     => 'no',
			'show_search_form'                  => 'yes',
			'show_layout_switcher'              => 'no',
			'recipe_image_size'                 => 'recipe_image', //'recipe-image',
			'recipe_image_size_style1'          => 'recipe_image', //'recipe-image',
			'recipe_image_size_style2'          => 'recipe_image_style2', //'recipe-image',
			'color_archive_key_points_bg'       => '#058249',
			'color_archive_hover_overlay'       => 'rgba(255, 255, 255, 0.60)',
			'show_in_masonry'                   => 'yes',
			'show_rounded_card_border'          => 'no',
			'card_border_radius_pixels'         => 20,
			'card_border_pixels'                => 0,
			'recipes_per_row'                   => 3,
			'archive_layout_max_width'          => 1048,
			'layout_max_width'                  => 1048,
			'featured_image_height'             => 576,
			'recipes_per_page'                  => 12,
			'color_archive_title'               => '#333333',
			'color_accent'                      => '#71A866',
			'color_secondary'                   => 'rgba(113, 168, 102, 0.25)',
			'recipe_style'                      => 'style1',
			'color_icon'                        => '#71A866',
			'color_border'                      => '#bfbfbf',
			'color_card_border'                 => '#bfbfbf',
			'color_archive_excerpt'             => '#444444',
			'color_archive_keys'                => '#ffffff',
			'color_card_bg'                     => '#f6f6f6',
			'form_bg_color'                     => '#F6F6F6',
			'form_button_bg_color'              => '#3D4045',
			'form_button_text_color'            => '#FFFFFF',
			'override_theme_pagination_style'   => 'no',
			'recipe_widget_img_width'           => 50,
			'recipe_widget_bg_color'            => '#f6f6f6',
			'card_content_alignment'            => 'left',
			'show_share_buttons'                => 'yes',
			'uninstall_delete_options'          => 'yes',
			'uninstall_delete_mata'             => 'no',
		);


		$default_options = array_merge( $default_options, self::get_default_labels() );

		$default_options = apply_filters( 'boorecipe_filter_default_options_array', $default_options );

//		apply_filters( 'boorecipe_default_options_array_before_key_return', $default_options );

		return $default_options;
	}

	/**
	 * @return array $default_labels
	 */
	public static function get_default_labels() {

		$default_labels = array(
			'recipe_label'              => __( 'Recipe', 'boorecipe' ),
			'recipe_plural_label'       => __( 'Recipes', 'boorecipe' ),
			'recipe_category_label'     => __( 'Category', 'boorecipe' ),
			'skill_level_label'         => __( 'Skill Level', 'boorecipe' ),
			'skill_level_plural_label'  => __( 'Skill Levels', 'boorecipe' ),
			'recipe_tags_label'         => __( 'Usage', 'boorecipe' ),
			'prep_time_label'           => __( 'Prep', 'boorecipe' ),
			'cook_time_label'           => __( 'Cook', 'boorecipe' ),
			'total_time_label'          => __( 'Ready-in', 'boorecipe' ),
			'time_unit_minutes_label'   => __( 'mins', 'boorecipe' ),
			'time_unit_hours_label'     => __( 'hours', 'boorecipe' ),
			'yields_label'              => __( 'Yields', 'boorecipe' ),
			'difficulty_level_label'    => __( 'Skill Level', 'boorecipe' ),
			'keyword_label'             => __( 'Keyword', 'boorecipe' ),
			'ingredients_label'         => __( 'Ingredients', 'boorecipe' ),
			'directions_label'          => __( 'Instructions', 'boorecipe' ),
			'additional_notes_label'    => __( 'Additional Notes', 'boorecipe' ),
			'nutrition_label'           => __( 'Nutrition', 'boorecipe' ),
			'nutrition_facts_label'     => __( 'Nutrition Facts', 'boorecipe' ),
			'submit_button_label'       => __( 'Search', 'boorecipe' ),
			'any_label'                 => __( 'Any', 'boorecipe' ),
			'all_label'                 => __( 'All', 'boorecipe' ),
			'archive_layout_grid_label' => _x( 'Grid', 'Post Archive Layout', 'boorecipe' ),
			'archive_layout_list_label' => _x( 'List', 'Post Archive Layout', 'boorecipe' ),

		);

		return apply_filters( 'boorecipe_filter_default_labels_array', $default_labels );

	}


	public static function get_meta_prefix(){
		return 'boorecipe_';
	}

	public static function get_current_language_code() {
//
		require_once BOORECIPE_BASE_DIR . 'admin/Exopite-Simple-Options-Framework/exopite-simple-options/multilang-class.php';

		return Exopite_Simple_Options_Framework_Helper::get_current_language_code();

	}

	public static function set_current_language_code() {
//
		require_once BOORECIPE_BASE_DIR . 'admin/Exopite-Simple-Options-Framework/exopite-simple-options/multilang-class.php';

		self::$current_language_code = Exopite_Simple_Options_Framework_Helper::get_current_language_code();
		self::$default_language_code = Exopite_Simple_Options_Framework_Helper::get_default_language_code();

	}

	public static function is_special_multilang_plugin_active() {

		require_once BOORECIPE_BASE_DIR . 'admin/Exopite-Simple-Options-Framework/exopite-simple-options/multilang-class.php';

		return Exopite_Simple_Options_Framework_Helper::is_special_multilang_plugin_active();

	}

	/**
	 * @param $key
	 *
	 * @return bool|mixed
	 */
	public static function get_default_label( $key ) {

		$default_labels = self::get_default_labels();

		return isset( $default_labels[ $key ] ) ? $default_labels[ $key ] : false;


	}

	/**
	 * Check if the shortcode type 'single' is active
	 * @return bool
	 */
	public static function is_active_shortcode_single() {

		return self::is_active_shortcode_of_type( 'single' );

	}

	/**
	 * Check if the shortcode type 'single' is active
	 *
	 * @param string $shortcode_type ['single'|'archive']
	 *
	 * @return bool
	 */
	protected static function is_active_shortcode_of_type( $shortcode_type ) {

		$registered_shortcodes_type = self::get_registered_shortcodes( $shortcode_type );

		if ( ! empty( $registered_shortcodes_type ) && is_array( $registered_shortcodes_type ) ) {
			foreach ( $registered_shortcodes_type as $shortcode ) {
				if ( is_string( $shortcode ) ) {
					$status = self::is_active_shortcode( $shortcode );
					// return and break out of loop
					if ( $status ) {
						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Check if the shortcode tag is in the page/post content
	 *
	 * @param $shortcode_tag
	 *
	 * @return bool
	 */
	public static function is_active_shortcode( $shortcode_tag ) {

		global $post;

		return ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, $shortcode_tag ) ) ? true : false;
	}

	/**
	 * Check if the shortcode type 'archive' is active
	 * @return bool
	 */
	public static function is_active_shortcode_archive() {

		return self::is_active_shortcode_of_type( 'archive' );

	}

	/**
	 * @param $meta_key
	 *
	 * @return bool|mixed
	 */
	public static function get_meta_key_label( $meta_key ) {
		$recipe_meta_key_label =
			(
				isset( self::$options["recipe_{$meta_key}_label"] )
				&&
				! empty( self::$options["recipe_{$meta_key}_label"] )
			)
				? self::$options["recipe_{$meta_key}_label"]
				: self::get_default_options( "recipe_{$meta_key}_label" );

		return $recipe_meta_key_label;
	}

	/**
	 * Returns the count of the largest arrays
	 *
	 * @param        array $array An array of arrays to count
	 *
	 * @return        int                    The count of the largest array
	 */
	public static function get_max( $array ) {

		if ( empty( $array ) ) {
			return '$array is empty!';
		}

		$count = array();

		foreach ( $array as $name => $field ) {

			$count[ $name ] = count( $field );

		} //

		$count = max( $count );

		return $count;

	} // get_max()

	/**
	 * Returns the requested SVG.
	 *
	 * @param        string $svg The name of an SVG
	 * @param        string $svg_class this class will be added to svg
	 *
	 * @return        mixed                    The SVG code
	 */
	public static function get_svg( $svg, $svg_class = 'icon-size-24' ) {

		$return = '';

		switch ( $svg ) {

			case 'drag':
				$return = '<svg width=24 height=24 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="drag"><path d="M19.7 10.5l-2.8 2.8c-.1.1-.3.2-.5.2-.4 0-.7-.3-.7-.7v-1.4h-4.3v4.3h1.4c.4 0 .7.3.7.7 0 .2-.1.4-.2.5l-2.8 2.8c-.1.1-.3.2-.5.2s-.4-.1-.5-.2l-2.8-2.8c-.1-.1-.2-.3-.2-.5 0-.4.3-.7.7-.7h1.4v-4.3H4.3v1.4c0 .4-.3.7-.7.7-.2 0-.4-.1-.5-.2L.3 10.5c-.1-.1-.2-.3-.2-.5s.1-.4.2-.5l2.8-2.8c.1-.1.3-.2.5-.2.4 0 .7.3.7.7v1.4h4.3V4.3H7.2c-.4 0-.7-.3-.7-.7 0-.2.1-.4.2-.5L9.5.3c.1-.1.3-.2.5-.2s.4.1.5.2l2.8 2.8c.1.1.2.3.2.5 0 .4-.3.7-.7.7h-1.4v4.3h4.3V7.2c0-.4.3-.7.7-.7.2 0 .4.1.5.2l2.8 2.8c.1.1.2.3.2.5s0 .4-.2.5z"/></svg>';
				break;

			case 'recipe_category':
				$return = '<svg width=24 height=24 version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 217.66 217.66" xml:space="preserve"  class="' . $svg_class . ' ' . $svg . '">
<g>
	<g>
		<path d="M90.876,32.933c-7.766-9.901,3.209-23.403,3.375-23.605c1.176-1.41,0.988-3.507-0.421-4.684
			c-1.41-1.181-3.509-0.992-4.689,0.418C88.993,5.238,85.5,9.452,83.27,15.328c-3.129,8.242-2.31,15.75,2.368,21.713
			c8.372,10.673-1.511,26.355-1.608,26.507c-0.998,1.544-0.556,3.604,0.988,4.602c0.559,0.362,1.185,0.534,1.804,0.534
			c1.092,0,2.161-0.537,2.798-1.522C90.138,66.361,102.189,47.356,90.876,32.933z"/>
	</g>
</g>
<g>
	<g>
		<path d="M136.186,32.933c-7.766-9.901,3.209-23.403,3.376-23.605c1.177-1.41,0.988-3.507-0.421-4.684
			c-1.41-1.181-3.51-0.992-4.689,0.418c-0.146,0.177-3.641,4.391-5.871,10.267c-3.129,8.242-2.311,15.75,2.367,21.713
			c8.371,10.673-1.511,26.355-1.608,26.507c-0.998,1.544-0.557,3.604,0.988,4.602c0.559,0.362,1.185,0.534,1.803,0.534
			c1.093,0,2.162-0.537,2.799-1.522C135.448,66.361,147.498,47.356,136.186,32.933z"/>
	</g>
</g>
<g>
	<g>
		<path d="M112.591,32.689c-9.041-10.888,3.31-27.065,3.498-27.309c1.133-1.447,0.879-3.538-0.567-4.67
			c-1.446-1.134-3.539-0.881-4.673,0.566c-0.654,0.835-15.879,20.613-3.379,35.667c11.516,13.868-0.916,29.519-1.447,30.172
			c-1.165,1.422-0.956,3.519,0.466,4.684c0.619,0.506,1.365,0.753,2.107,0.753c0.963,0,1.919-0.416,2.577-1.22
			c0.169-0.206,4.162-5.131,6.369-12.244C120.563,49.357,118.852,40.228,112.591,32.689z"/>
	</g>
</g>
<g>
	<g>
		<path d="M188.233,87.812H108.83H29.428c-1.838,0-3.329,1.49-3.329,3.328v12.803c0,1.724,1.31,3.141,2.989,3.311
			c0.179,0.031,11.027,0.049,11.027,0.049c-0.244,7.096,0.55,26.023,14.15,41.322c4.829,5.433,10.745,9.808,17.707,13.125
			l-19.104,51.421c-0.64,1.725,0.238,3.641,1.961,4.28c0.382,0.142,0.774,0.209,1.159,0.209c1.351,0,2.622-0.83,3.12-2.17
			l19.014-51.181c8.016,2.883,17.207,4.561,27.528,5.026v41.144c0,1.788,1.411,3.242,3.18,3.319c1.769-0.077,3.18-1.532,3.18-3.319
			v-41.144c10.321-0.467,19.512-2.145,27.528-5.026l19.014,51.181c0.498,1.34,1.77,2.17,3.119,2.17c0.386,0,0.777-0.068,1.16-0.209
			c1.723-0.641,2.601-2.556,1.961-4.28l-19.104-51.421c6.962-3.317,12.878-7.692,17.707-13.125
			c13.601-15.297,14.394-34.225,14.149-41.322c0,0,10.849-0.019,11.027-0.049c1.68-0.17,2.989-1.587,2.989-3.311V91.14
			C191.563,89.301,190.071,87.812,188.233,87.812z M158.369,144.259c-10.033,11.246-25.613,17.428-46.359,18.416v-12.209
			c0-1.787-1.411-3.242-3.18-3.32c-1.769,0.078-3.18,1.534-3.18,3.32v12.209c-20.746-0.988-36.326-7.169-46.36-18.416
			c-12.131-13.598-12.696-31.056-12.499-36.954h62.039h62.04C171.065,113.202,170.5,130.661,158.369,144.259z M184.905,100.615
			H108.83H32.755V94.47h76.075h76.075V100.615z"/>
	</g>
</g>
</svg>';
				break;

			case 'tags':
			case 'recipe_tags':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="far" data-icon="tags" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M625.941 293.823L421.823 497.941c-18.746 18.746-49.138 18.745-67.882 0l-.36-.36L592 259.882 331.397 0h48.721a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882zm-128 0L293.823 497.941C284.451 507.314 272.166 512 259.882 512c-12.284 0-24.569-4.686-33.941-14.059L14.059 286.059A48 48 0 0 1 0 252.118V48C0 21.49 21.49 0 48 0h204.118a47.998 47.998 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882zM464 259.882L252.118 48H48v204.118l211.886 211.878L464 259.882zM144 96c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48z" class=""></path></svg>';
				break;

			case 'recipe_cuisine':
				$return = '<svg width=24 height=24 aria-hidden="true" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 204.09 204.09" class="' . $svg_class . ' ' . $svg . '"><g>
	<g>
		<path d="M151.037,52.201c4.873-6.212,5.724-14.037,2.463-22.629c-2.329-6.136-5.976-10.535-6.13-10.719
			c-1.195-1.43-3.324-1.62-4.754-0.424c-1.43,1.195-1.619,3.32-0.428,4.75c0.164,0.199,11.729,14.412,3.537,24.856
			c-11.796,15.041,0.781,34.878,1.322,35.715c0.646,0.999,1.731,1.543,2.838,1.543c0.628,0,1.263-0.175,1.829-0.541
			c1.564-1.012,2.014-3.101,1.002-4.667C152.612,79.925,142.221,63.44,151.037,52.201z"/>
	</g>
</g>
<g>
	<g>
		<path d="M173.691,52.201c4.873-6.212,5.724-14.037,2.463-22.629c-2.33-6.136-5.977-10.535-6.131-10.719
			c-1.194-1.43-3.324-1.62-4.754-0.424c-1.428,1.194-1.619,3.319-0.428,4.749c0.118,0.143,11.746,14.392,3.537,24.857
			c-11.796,15.041,0.782,34.878,1.323,35.715c0.646,0.999,1.73,1.543,2.837,1.543c0.628,0,1.263-0.175,1.83-0.541
			c1.565-1.012,2.014-3.101,1.002-4.667C175.267,79.925,164.875,63.44,173.691,52.201z"/>
	</g>
</g>
<g>
	<g>
		<path d="M31.972,53.765c4.873-6.212,5.724-14.037,2.463-22.629c-2.33-6.136-5.976-10.535-6.13-10.719
			c-1.195-1.43-3.323-1.62-4.754-0.424c-1.428,1.194-1.619,3.319-0.428,4.749c0.119,0.143,11.746,14.392,3.538,24.857
			c-11.798,15.041,0.78,34.877,1.322,35.715c0.646,0.999,1.73,1.543,2.837,1.543c0.628,0,1.263-0.175,1.829-0.541
			c1.565-1.012,2.014-3.102,1.001-4.667C33.547,81.489,23.155,65.004,31.972,53.765z"/>
	</g>
</g>
<g>
	<g>
		<path d="M54.626,53.765c4.873-6.212,5.724-14.037,2.464-22.629c-2.329-6.136-5.976-10.535-6.13-10.719
			c-1.195-1.43-3.323-1.62-4.754-0.424c-1.428,1.194-1.619,3.319-0.428,4.749c0.119,0.143,11.746,14.392,3.537,24.857
			c-11.798,15.041,0.78,34.877,1.321,35.715c0.646,0.999,1.73,1.543,2.837,1.543c0.628,0,1.263-0.175,1.83-0.541
			c1.565-1.012,2.014-3.102,1.001-4.667C56.201,81.489,45.809,65.004,54.626,53.765z"/>
	</g>
</g>
<g>
	<g>
		<path d="M192.886,159.814h-7.159c-1.681-42.103-34.652-76.291-76.241-79.901v-3.437c4.223-2.526,6.845-7.054,6.845-12.088
			c0-7.792-6.341-14.132-14.133-14.132c-0.051,0-0.254,0-0.305,0c-7.793,0-14.133,6.34-14.133,14.132
			c0,5.034,2.623,9.563,6.844,12.088v3.437c-41.588,3.61-74.56,37.797-76.241,79.901h-7.159C5.026,159.814,0,164.84,0,171.017v4.22
			c0,6.182,5.026,11.21,11.203,11.21h181.684c6.178,0,11.203-5.028,11.203-11.21v-4.22
			C204.089,164.84,199.063,159.814,192.886,159.814z M94.508,64.388c0-4.07,3.312-7.382,7.383-7.382c0.052,0,0.254,0,0.305,0
			c4.071,0,7.383,3.312,7.383,7.382c0,3.043-1.846,5.735-4.703,6.856c-1.292,0.507-2.141,1.754-2.141,3.142v5.211h-1.383v-5.211
			c0-1.388-0.85-2.634-2.141-3.142C96.354,70.122,94.508,67.431,94.508,64.388z M192.886,179.696H11.202
			c-2.456,0-4.453-2.001-4.453-4.46v-4.22c0-2.455,1.998-4.452,4.453-4.452h5.549c0.031,0.001,0.06,0.005,0.091,0.005h121.202
			c1.863,0,3.375-1.511,3.375-3.375c0-1.863-1.512-3.375-3.375-3.375H25.122c1.766-40.712,35.356-73.309,76.458-73.473h0.928
			c41.103,0.164,74.691,32.76,76.458,73.473h-19.092c-1.864,0-3.375,1.512-3.375,3.375c0,1.864,1.511,3.375,3.375,3.375
			l26.063-0.005h6.948c2.456,0,4.453,1.997,4.453,4.452v4.22h0.001C197.339,177.695,195.341,179.696,192.886,179.696z"/>
	</g>
</g></svg>';
				break;


			case 'clock':
			case 'total_time':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fal" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm216 248c0 118.7-96.1 216-216 216-118.7 0-216-96.1-216-216 0-118.7 96.1-216 216-216 118.7 0 216 96.1 216 216zm-148.9 88.3l-81.2-59c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h14c6.6 0 12 5.4 12 12v146.3l70.5 51.3c5.4 3.9 6.5 11.4 2.6 16.8l-8.2 11.3c-3.9 5.3-11.4 6.5-16.8 2.6z" class=""></path></svg>';
				break;

			case 'utensils':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fal" data-icon="utensils-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M0 60c0 142.9 69.8 215.8 188.6 226.5L84.2 379.1c-25.8 22.9-27 63-2.6 87.3l28 28c24.6 24.6 64.6 23.1 87.3-2.6L290 386.7c96.3 113.5 89.4 105.4 90.3 106.3 22.9 24.4 61.9 25.7 86.2 1.4l28-28c24.1-24.1 23.2-63.3-1.6-86.4L384.8 279.7l7.2-7.7c38.8 12.1 77.1 7 110.3-26.1 20.9-20.9 61.7-79.7 66.8-87.1 20.1-28.5-7.3-66.8-37.4-70.6-2.8-22.1-23.6-41.5-43.9-44-3.9-31-42.6-57.1-70.6-37.4-7.4 5.1-66.2 46-87.1 66.9C298 105.8 291.4 144 304 184l-11.2 10.3-192-178.2C62.6-19.4 0 7.7 0 60zm379.7 177.2l-18.4 20.7-44.9-41.7 22.5-19.9c-18.8-33-15.4-70.7 13.9-100C372.3 76.7 435.6 33 435.6 33c7.6-5.5 25.1 12.3 19.4 19.7l-81 80.9c-7 8.2 10.9 26.4 19.4 19.7l86.1-76.4c7.4-5.4 24.9 12 19.5 19.5l-76.4 86.1C416 191 434.1 209 442.4 202l80.9-80.9c7.4-5.8 25.2 11.8 19.7 19.4 0 0-43.7 63.2-63.3 82.9-29.6 29.4-67.3 32.4-100 13.8zm-161 65.5l50.4 59.3L173 470.6c-10.7 12-29.3 12.7-40.8 1.2l-28-28c-11.4-11.4-10.8-30.1 1.2-40.8l113.3-100.3zM32 60c0-24.4 29.1-37.2 47.1-20.5l392 364c11.6 10.8 12 29.1.7 40.3l-28 28c-11.2 11.2-29.4 10.9-40.2-.6L221 256C81 256 32 177.2 32 60z" class=""></path></svg>';
				break;

			case 'yields':
				$return = '<svg width=24 height=24 version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 177.809 177.809" xml:space="preserve" class="' . $svg_class . ' ' . $svg . '">
<g>
	<g>
		<path d="M132.534,152.942C126.145,143.152,32.616,20.01,18.596,3.107c-1.946-2.348-4.265-1.612-5.133-0.756
			c-1.508,1.486-2.412,3.655,0.745,16.652C16.099,26.79,30.86,70.202,35.89,82.675c10.235,25.374,16.786,24.537,20.539,25.02
			c1.833,0.236,3.616-0.194,5.157-1.247c4.197-2.864,5.597-3.699,7.218-4.667c0.569-0.339,1.176-0.702,1.936-1.169
			c4.537,7.434,10.138,18.967,15.576,30.164c7.317,15.067,14.884,30.648,20.93,38.711c3.845,5.125,8.003,6.633,10.815,6.994
			c5.382,0.692,10.948-2.192,14.183-7.348C135.527,163.9,135.638,157.695,132.534,152.942z M126.528,165.544
			c-1.839,2.933-4.824,4.597-7.604,4.239c-2.182-0.28-4.353-1.785-6.275-4.349c-5.658-7.543-13.08-22.827-20.259-37.609
			c-6.558-13.503-12.752-26.258-17.819-33.751c-0.565-0.835-1.438-1.337-2.366-1.457c-0.763-0.098-1.564,0.063-2.26,0.513
			c-2.266,1.463-7.795,4.76-12.163,7.741c-0.2,0.137-0.317,0.15-0.49,0.129c-2.315,1.198-2.462-0.561-6.369-5.864
			C44.628,86.595,26.858,36.42,21.718,19.94c-1.994-6.391,0.13-2.867,1.692-0.857c16.886,21.724,97.265,128.039,103.472,137.55
			C128.851,159.647,127.99,163.213,126.528,165.544z"/>
	</g>
</g>
<g>
	<g>
		<path d="M176.857,35.657c-1.299-1.338-3.436-1.37-4.772-0.071c-8.615,8.358-16.65,16.508-23.106,23.057
			c-1.649,1.674-3.16,3.206-4.528,4.587l-6.365-6.37l26.897-26.098c1.338-1.298,1.369-3.436,0.071-4.773
			c-1.298-1.337-3.434-1.37-4.772-0.071l-26.969,26.167l-5.992-5.997l27.058-26.254c1.338-1.299,1.37-3.436,0.072-4.772
			c-1.298-1.338-3.436-1.37-4.772-0.072l-27.129,26.323l-5.837-5.842L146.03,7.023c1.338-1.298,1.37-3.435,0.071-4.771
			c-1.298-1.339-3.434-1.37-4.771-0.072l-33.74,32.738c-8.623,8.366-7.957,20.653,1.438,31.985l-19.189,18.9
			c-1.338,1.298-1.37,3.435-0.072,4.771c0.522,0.538,1.181,0.865,1.867,0.979c1.021,0.17,2.106-0.131,2.906-0.907l19.203-18.914
			c3.781,3.148,8.251,5.231,12.947,6.011c0.604,0.102,1.215,0.18,1.826,0.236c6.129,0.57,11.745-1.144,15.412-4.702
			c2.342-2.271,5.657-5.635,9.856-9.894c6.433-6.524,14.438-14.645,23-22.951C178.122,39.132,178.154,36.995,176.857,35.657z
			 M139.227,68.432c-2.217,2.149-5.987,3.206-10.087,2.824c-4.737-0.44-9.29-2.684-12.812-6.314
			c-6.9-7.112-11.598-17.279-4.449-24.758l27.792,27.815C139.519,68.147,139.371,68.292,139.227,68.432z"/>
	</g>
</g>
<g>
	<g>
		<path d="M74.589,116.551c-1.394-1.239-3.527-1.113-4.765,0.281c-13.581,15.281-38.227,42.276-46.543,49.652
			c-4.134,3.667-10.646,2.188-14.133-1.496c-3.647-3.852-3.097-8.73,1.509-13.388c11.695-11.819,28.924-25.353,41.919-35.153
			c1.488-1.122,1.785-3.238,0.663-4.727s-3.238-1.785-4.727-0.663c-13.162,9.926-30.649,23.663-42.653,35.795
			c-8.742,8.837-6.332,17.792-1.612,22.776c2.667,2.815,6.444,4.841,10.456,5.507c4.464,0.741,9.219-0.199,13.057-3.604
			c9.61-8.523,37.266-39.142,47.11-50.219C76.108,119.922,75.982,117.787,74.589,116.551z"/>
	</g>
</g>
</svg>';
				break;


			case 'grid':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fas" data-icon="th" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M149.333 56v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zm181.334 240v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm32-240v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24zm-32 80V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm-205.334 56H24c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm386.667-56H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm0 160H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zM181.333 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24z" class=""></path></svg>';
				break;

			case 'list':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fas" data-icon="list" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M128 116V76c0-8.837 7.163-16 16-16h352c8.837 0 16 7.163 16 16v40c0 8.837-7.163 16-16 16H144c-8.837 0-16-7.163-16-16zm16 176h352c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H144c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h352c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H144c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zM16 144h64c8.837 0 16-7.163 16-16V64c0-8.837-7.163-16-16-16H16C7.163 48 0 55.163 0 64v64c0 8.837 7.163 16 16 16zm0 160h64c8.837 0 16-7.163 16-16v-64c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v64c0 8.837 7.163 16 16 16zm0 160h64c8.837 0 16-7.163 16-16v-64c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v64c0 8.837 7.163 16 16 16z" class=""></path></svg>';
				break;

			case 'difficulty_level':
			case 'skill_level':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fal" data-icon="graduation-cap" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M612.16 153.99l-265-85.68c-17.81-5.75-36.5-5.75-54.31 0l-265 85.68C10.94 159.46 0 174.38 0 192s10.94 32.54 27.84 38.01l29.71 9.6c-3.3 6.18-5.74 12.83-7.33 19.8C39.53 264.59 32 275.32 32 288c0 12.73 7.57 23.52 18.33 28.67L32.28 428.53C30.67 438.52 36.19 448 43.62 448h40.75c7.43 0 12.96-9.48 11.34-19.47L77.67 316.67C88.43 311.52 96 300.73 96 288c0-10.6-5.49-19.54-13.43-25.37 1.49-4.66 3.8-8.86 6.57-12.81l53.47 17.29L128 384c0 35.35 85.96 64 192 64s192-28.65 192-64l-14.61-116.89L612.16 230c16.9-5.46 27.84-20.38 27.84-38s-10.94-32.54-27.84-38.01zM479.48 381.86C468.72 393.19 414.04 416 320 416c-94.04 0-148.72-22.81-159.48-34.14l13.09-104.73 119.24 38.55c2.6.84 25.72 9.23 54.31 0l119.24-38.55 13.08 104.73zm122.8-182.28l-265 85.68c-11.31 3.66-23.25 3.66-34.56 0l-175.67-56.8 195.89-36.74c8.69-1.62 14.41-9.98 12.78-18.67-1.62-8.7-10.16-14.39-18.66-12.77l-203.78 38.2c-12.4 2.32-23.51 7.65-33.08 14.83l-42.49-13.74c-7.85-2.55-7.46-12.74 0-15.15l265-85.68c15.1-4.88 27.84-2.17 34.56 0l265 85.68c7.39 2.39 7.91 12.6.01 15.16z" class=""></path></svg>';
				break;

			case 'cooking_method':
				$return = '<svg width=24 height=24 version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 176.2 176.2" xml:space="preserve" class="' . $svg_class . ' ' . $svg . '">
<g>
	<g>
		<path d="M157.894,51.56c-4.556-4.556-10.612-7.065-17.056-7.065c-6.442,0-12.5,2.509-17.056,7.065l-12.335,12.334
			c0,0,0.048-13.088,0.048-13.766C111.496,22.487,89.008,0,61.368,0C33.728,0,11.24,22.487,11.24,50.128v96.596
			c0,1.865,1.511,3.375,3.375,3.375h4.584v22.726c0,1.864,1.511,3.375,3.375,3.375h77.052c1.864,0,3.375-1.511,3.375-3.375v-22.726
			h5.073c1.863,0,3.375-1.51,3.375-3.375v-11.908l46.131-48.843l0.037-0.035c0.094-0.088,0.188-0.175,0.279-0.267
			c4.556-4.556,7.064-10.614,7.064-17.057C164.959,62.172,162.451,56.115,157.894,51.56z M38.549,169.449h-12.6V150.55h12.6V169.449
			z M57.159,169.449h-11.86V150.55h11.86V169.449z M75.769,169.449h-11.86V150.55h11.86V169.449z M96.25,169.449H82.52V150.55h13.73
			V169.449z M153.122,80.898c-0.036,0.036-0.073,0.07-0.11,0.105l-0.154,0.144c-0.041,0.039-0.08,0.079-0.118,0.12l-46.772,49.522
			c-0.771,0.619-1.269,1.568-1.269,2.635v9.926H17.99V50.128c0-23.919,19.459-43.378,43.378-43.378
			c23.919,0,43.378,19.459,43.378,43.378c0,0.601-0.016,1.229-0.045,1.918c-0.002,0.049-0.003,35.649-0.003,35.649
			c0,1.864,1.511,3.375,3.375,3.375c1.864,0,3.375-1.512,3.375-3.375V73.441l17.108-17.108c3.28-3.281,7.643-5.087,12.282-5.087
			c4.639,0,9.003,1.807,12.283,5.088c3.28,3.281,5.087,7.643,5.087,12.282C158.209,73.255,156.403,77.617,153.122,80.898z"/>
	</g>
</g>
</svg>';
				break;


			case 'ingredients':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fal" data-icon="mortar-pestle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M504 192H390.63L497.36 85.27c24.11-24.11 17.51-64.75-12.98-80A49.957 49.957 0 0 0 462.05 0c-10.62 0-21.16 3.38-29.98 9.99L189.39 192H8c-4.42 0-8 3.58-8 8v16c0 4.42 3.58 8 8 8h24v32c0 81.42 50.76 150.83 122.29 178.75-12.76 16.78-21.7 36.63-24.92 58.44-1.45 9.83 5.98 18.81 15.92 18.81h221.42c9.94 0 17.37-8.97 15.92-18.81-3.21-21.81-12.15-41.67-24.92-58.44C429.24 406.83 480 337.42 480 256v-32h24c4.42 0 8-3.58 8-8v-16c0-4.42-3.58-8-8-8zM451.26 35.59c17.58-13.18 39.21 11.31 23.47 27.05L345.38 192H242.72L451.26 35.59zM448 256c0 66.31-40.01 124.77-101.92 148.94l-39.51 15.42 25.68 33.76c6.08 8 10.87 16.75 14.19 25.88H165.57c3.32-9.13 8.1-17.88 14.19-25.88l25.68-33.76-39.51-15.42C104.01 380.77 64 322.31 64 256v-32h384v32z" class=""></path></svg>';
				break;

			case 'star_full':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z" class=""></path></svg>';
				break;

			case 'star_empty':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fal" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM405.8 317.9l27.8 162L288 403.5 142.5 480l27.8-162L52.5 203.1l162.7-23.6L288 32l72.8 147.5 162.7 23.6-117.7 114.8z" class=""></path></svg>';
				break;

			case 'star':
				$return = '	<svg width=24 height=24 class="star rating" data-rating="1">
    <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
  </svg>';
				break;

			case 'smiley':
				$return = '<svg width=24 height=24 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="' . $svg_class . ' ' . $svg . '"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.507 13.941c-1.512 1.195-3.174 1.931-5.506 1.931-2.334 0-3.996-.736-5.508-1.931l-.493.493c1.127 1.72 3.2 3.566 6.001 3.566 2.8 0 4.872-1.846 5.999-3.566l-.493-.493zm-9.007-5.941c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5-.672-1.5-1.5-1.5zm7 0c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5-.672-1.5-1.5-1.5z"/></svg>';
				break;

			case 'print':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fal" data-icon="print" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M416 192V81.9c0-6.4-2.5-12.5-7-17L351 7c-4.5-4.5-10.6-7-17-7H120c-13.2 0-24 10.8-24 24v168c-53 0-96 43-96 96v136c0 13.2 10.8 24 24 24h72v40c0 13.2 10.8 24 24 24h272c13.2 0 24-10.8 24-24v-40h72c13.2 0 24-10.8 24-24V288c0-53-43-96-96-96zM128 32h202.8L384 85.2V256H128V32zm256 448H128v-96h256v96zm96-64h-64v-40c0-13.2-10.8-24-24-24H120c-13.2 0-24 10.8-24 24v40H32V288c0-35.3 28.7-64 64-64v40c0 13.2 10.8 24 24 24h272c13.2 0 24-10.8 24-24v-40c35.3 0 64 28.7 64 64v128zm-28-112c0 11-9 20-20 20s-20-9-20-20 9-20 20-20 20 9 20 20z" class=""></path></svg>';
				break;

			case 'facebook':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fab" data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 264 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229" class=""></path></svg>';
				break;

			case 'twitter':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z" class=""></path></svg>';
				break;

			case 'youtube':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fab" data-icon="youtube" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z" class=""></path></svg>';
				break;

			case 'pinterest':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fab" data-icon="pinterest-p" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z" class=""></path></svg>';
				break;

			case 'googleplus':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fab" data-icon="google-plus-g" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M386.061 228.496c1.834 9.692 3.143 19.384 3.143 31.956C389.204 370.205 315.599 448 204.8 448c-106.084 0-192-85.915-192-192s85.916-192 192-192c51.864 0 95.083 18.859 128.611 50.292l-52.126 50.03c-14.145-13.621-39.028-29.599-76.485-29.599-65.484 0-118.92 54.221-118.92 121.277 0 67.056 53.436 121.277 118.92 121.277 75.961 0 104.513-54.745 108.965-82.773H204.8v-66.009h181.261zm185.406 6.437V179.2h-56.001v55.733h-55.733v56.001h55.733v55.733h56.001v-55.733H627.2v-56.001h-55.733z" class=""></path></svg>';
				break;


			case 'linkedin':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fab" data-icon="linkedin-in" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M100.3 480H7.4V180.9h92.9V480zM53.8 140.1C24.1 140.1 0 115.5 0 85.8 0 56.1 24.1 32 53.8 32c29.7 0 53.8 24.1 53.8 53.8 0 29.7-24.1 54.3-53.8 54.3zM448 480h-92.7V334.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V480h-92.8V180.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V480z" class=""></path></svg>';
				break;

			case 'envelope':
			case 'email':
				$return = '<svg width=24 height=24 aria-hidden="true" data-prefix="fal" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="' . $svg_class . ' ' . $svg . '"><path fill="currentColor" d="M464 64H48C21.5 64 0 85.5 0 112v288c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM48 96h416c8.8 0 16 7.2 16 16v41.4c-21.9 18.5-53.2 44-150.6 121.3-16.9 13.4-50.2 45.7-73.4 45.3-23.2.4-56.6-31.9-73.4-45.3C85.2 197.4 53.9 171.9 32 153.4V112c0-8.8 7.2-16 16-16zm416 320H48c-8.8 0-16-7.2-16-16V195c22.8 18.7 58.8 47.6 130.7 104.7 20.5 16.4 56.7 52.5 93.3 52.3 36.4.3 72.3-35.5 93.3-52.3 71.9-57.1 107.9-86 130.7-104.7v205c0 8.8-7.2 16-16 16z" class=""></path></svg>';
				break;


		} // switch

		return $return;

	} // get_svg()

	/**
	 * Returns the path to a template file
	 *
	 * Looks for the file in these directories, in this order:
	 *        Current theme
	 *        Parent theme
	 *        Current theme templates folder
	 *        Parent theme templates folder
	 *        This plugin
	 *
	 * To use a custom list template in a theme, copy the
	 * file from public/templates into a templates folder in your
	 * theme. Customize as needed, but keep the file name as-is. The
	 * plugin will automatically use your custom template file instead
	 * of the ones included in the plugin.
	 *
	 * @param    string $name The name of a template file
	 * @param
	 *
	 * @return    string                        The path to the template
	 */
	public static function get_template( $name, $sub_directory = null ) {

		$locations[] = "{$name}.php";
		$locations[] = "/templates/{$name}.php";

		/**
		 * Filter the locations to search for a template file
		 *
		 * @param    array $locations File names and/or paths to check
		 */
		$locations = apply_filters( 'boorecipe_template_paths', $locations );

		$template = locate_template( $locations, true );


		// If we cannot find template path,
		if ( empty( $template ) ) {

			if ( $sub_directory != null ) {
				$sub_directory_path = sanitize_key( $sub_directory ) . '/';
			} else {
				$sub_directory_path = '';
			}

			$template = plugin_dir_path( dirname( __FILE__ ) ) . "public/templates/$sub_directory_path" . $name . '.php';

			if ( ! is_file( $template ) ) {

				$try_to_get_file = apply_filters( 'boorecipe_template_additional_paths', array(
					'name'               => $name,
					'sub_directory_path' => $sub_directory_path
				) );

				if ( ! is_array( $try_to_get_file ) && is_file( $try_to_get_file ) ) {
					$template = $try_to_get_file;
				}

			}

		}

		return $template;

	} // get_template()

} // class
