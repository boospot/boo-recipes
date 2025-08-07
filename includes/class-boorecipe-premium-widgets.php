<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Boorecipe_Premium_Widgets' ) ) {
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
class Boorecipe_Premium_Widgets {

	/**
	 * Registers widgets with WordPress
	 *
	 * @since        1.0.0
	 * @access        public
	 */
	public function widgets_init() {

		// Require the base class defined in the Base  plugin
		require_once BOORECIPE_BASE_DIR . 'includes/widgets/class-boorecipe-widget-master.php';


		require_once BOORECIPE_BASE_DIR . 'includes/widgets/class-boorecipe-premium-widget-recipe-cuisines.php';
		register_widget( 'BoorecipePremiumWidgetRecipeCuisines' );


		require_once BOORECIPE_BASE_DIR . 'includes/widgets/class-boorecipe-premium-widget-recipe-card.php';
		register_widget( 'BoorecipePremiumWidgetRecipeCard' );

	} // widgets_init()


}