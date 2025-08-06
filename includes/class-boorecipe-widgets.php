<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Widgets' ) ) {
	return;
}
/**
 * The widget-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Boorecipe
 * @subpackage Boorecipe/widgets
 * @author     Rao Abid <raoabid491@gmail.com>
 */


class Boorecipe_Widgets {

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
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Registers widgets with WordPress
	 *
	 * @since        1.0.0
	 * @access        public
	 */
	public function widgets_init() {

		// Master Widget Class that is used as abstract class
		require_once BOORECIPE_BASE_DIR . 'includes/widgets/class-boorecipe-widget-master.php';

		require_once BOORECIPE_BASE_DIR . 'includes/widgets/class-boorecipe-widget-recipes.php';
		register_widget( 'BoorecipeWidgetRecipes' );

		require_once BOORECIPE_BASE_DIR . 'includes/widgets/class-boorecipe-widget-search-recipes.php';
		register_widget( 'BoorecipeWidgetSearchRecipes' );

		require_once BOORECIPE_BASE_DIR . 'includes/widgets/class-boorecipe-widget-recipe-categories.php';
		register_widget( 'BoorecipeWidgetRecipeCategories' );

		require_once BOORECIPE_BASE_DIR . 'includes/widgets/class-boorecipe-widget-recipe-skill-level.php';
		register_widget( 'BoorecipeWidgetRecipeSkillLevel' );

		require_once BOORECIPE_BASE_DIR . 'includes/widgets/class-boorecipe-widget-recipe-tags-cloud.php';
		register_widget( 'BoorecipeWidgetRecipeTagsCloud' );

	} // widgets_init()


}