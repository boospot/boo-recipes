<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BoorecipeWidgetRecipeTagsCloud
 */
class BoorecipeWidgetRecipeTagsCloud extends Boorecipe_Widget_Master {

	/**
	 * BoorecipeWidgetRecipeTagsCloud constructor.
	 */
	public function __construct() {

		$this->widget_cssclass    = 'boorecipe widget_recipe_tags_cloud';
		$this->widget_description = __( "This widget has no options", 'boo-recipes' );
		$this->widget_id          = 'boorecipe_recipe_tag_cloud';
		$this->widget_name        = __( 'Recipe Tags Cloud', 'boo-recipes' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Recipe Tags', 'boo-recipes' ),
				'label' => __( 'Title', 'boo-recipes' ),
			),
		);

//		WP_Widget::__construct('boorecipe-widget-recipes',$this->widget_name , $this->settings);
		parent::__construct();

	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {

		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();
		$this->widget_start( $args, $instance );
		echo wp_kses_post( '</ul>' );

		$query_args = array(
			'smallest'                  => 8,
			'largest'                   => 22,
			'unit'                      => 'pt',
			'number'                    => 45,
			'format'                    => 'flat',
			'separator'                 => "\n",
			'orderby'                   => 'name',
			'order'                     => 'ASC',
			'exclude'                   => null,
			'include'                   => null,
			'topic_count_text_callback' => 'default_topic_count_text',
			'link'                      => 'view',
			'taxonomy'                  => 'recipe_tags',
			'echo'                      => true,
			'child_of'                  => null, // see Note!
		);

		wp_tag_cloud( $query_args );

		$this->widget_end( $args );

		echo $this->cache_widget( $args, ob_get_clean() ); // WPCS: XSS ok.

	}


}