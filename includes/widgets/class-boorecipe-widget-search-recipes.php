<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BoorecipeWidgetSearchRecipes
 */
class BoorecipeWidgetSearchRecipes extends Boorecipe_Widget_Master {

	/**
	 * BoorecipeWidgetSearchRecipes constructor.
	 */
	function __construct() {

		$this->widget_cssclass    = 'boorecipe widget_recipe_search_form';
		$this->widget_description = __( "This will display search form for Recipes", 'boo-recipes' );
		$this->widget_id          = 'boorecipe_recipe_search_recipe';
		$this->widget_name        = __( 'Recipe Search Form', 'boo-recipes' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Search Recipes', 'boo-recipes' ),
				'label' => __( 'Title', 'boo-recipes' ),
			),
		);

		parent::__construct();


	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {

		ob_start();

		$this->widget_start( $args, $instance );
		echo do_shortcode( '[boorecipe_search_form]' );
		$this->widget_end( $args );

		echo $this->cache_widget( $args, ob_get_clean() ); // WPCS: XSS ok.


	}

}