<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// if class already defined, bail out
if ( class_exists( 'Boorecipe_Customization' ) ) {
	return;
}

/**
 * This class will be used for customization
 */
class Boorecipe_Customization {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	} // __construct()

	/**
	 * Will be loaded only on single recipe page or where shortcode loaded
	 *
	 * @hooked : wp_head
	 */
	public function recipe_single_configurable_styles() {

		if ( is_singular( 'boo_recipe' ) || boorecipe_is_active_shortcode_single() ):

			$accent_color     = $this->get_options_value( 'color_accent' );
			$secondary_color  = $this->get_options_value( 'color_secondary' );
			$icon_color       = $this->get_options_value( 'color_icon' );
			$border_color     = $this->get_options_value( 'color_border' );
			$image_height     = $this->get_options_value( 'featured_image_height' );
			$layout_max_width = $this->get_options_value( 'layout_max_width' );

			include boorecipe_get_template( 'single-configurable', 'styles' );

		endif;

	}

	/**
	 * Get Options Value from class Boorecipe_Globals
	 *
	 * @param $option_id
	 *
	 * @return mixed
	 */
	protected function get_options_value( $option_id ) {
		return Boorecipe_Globals::get_options_value( $option_id );
	}

	/**
	 * Will be loaded only on archive pages or recipe taxonomy pages
	 *
	 * @hooked : wp_head
	 */
	public function recipe_archive_configurable_styles() {

		if ( is_post_type_archive( 'boo_recipe' ) || boorecipe_is_tax_query() ) :

			$form_bg_color                = $this->get_options_value( 'form_bg_color' );
			$form_button_bg_color         = $this->get_options_value( 'form_button_bg_color' );
			$form_button_text_color       = $this->get_options_value( 'form_button_text_color' );
			$archive_layout_max_width     = $this->get_options_value( 'archive_layout_max_width' );
			$color_archive_title          = $this->get_options_value( 'color_archive_title' );
			$color_archive_excerpt        = $this->get_options_value( 'color_archive_excerpt' );
			$color_archive_keys           = $this->get_options_value( 'color_archive_keys' );
			$color_archive_key_points_bg  = $this->get_options_value( 'color_archive_key_points_bg' );
			$color_card_bg                = $this->get_options_value( 'color_card_bg' );
			$is_override_pagination_style = $this->get_options_value( 'override_theme_pagination_style' );

			include boorecipe_get_template( 'archive-configurable', 'styles' );

			if ( $is_override_pagination_style === 'yes' ) {
				include boorecipe_get_template( 'pagination-configurable', 'styles' );
			}

		endif;

	}

	/**
	 * This CSS will be loaded everywhere.
	 *
	 * @hooked : wp_head
	 *  TODO : Restrict the loading of this CSS and other global CSS file to only where required.
	 */
	public function recipe_global_configurable_styles() {


//		Widgets Settings
		$form_bg_color           = $this->get_options_value( 'form_bg_color' );
		$form_button_bg_color    = $this->get_options_value( 'form_button_bg_color' );
		$form_button_text_color  = $this->get_options_value( 'form_button_text_color' );
		$recipe_widget_img_width = $this->get_options_value( 'recipe_widget_img_width' );
		$recipe_widget_bg_color  = $this->get_options_value( 'recipe_widget_bg_color' );


//      custom CSS BOX

		$custom_css = (
			! empty( trim( $this->get_options_value( 'custom_css_editor' ) ) )
			&&
			is_string( $this->get_options_value( 'custom_css_editor' ) )
		)
			? $this->get_options_value( 'custom_css_editor' )
			: '';

		include boorecipe_get_template( 'global-configurable', 'styles' );


	}

}
