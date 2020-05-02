<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BoorecipeWidgetRecipeCategories
 */
class BoorecipeWidgetRecipeCategories extends Boorecipe_Widget_Master {

	public function __construct() {
		/*		// Instantiate the parent object
		//		parent::__construct( false, 'Recent Recipes' );
		//
		//		$widget_options = array(
		//			'classname' =>  'boorecipe-widget-recent-recipes',
		//			'description' => __('This will display a recipes from your site' , 'boo-recipes')
		//		);*/

		$this->widget_cssclass    = 'boorecipe widget_recipe_cats';
		$this->widget_description = __( "A list of your recipe Categories", 'boo-recipes' );
		$this->widget_id          = 'boorecipe_recipe_cat';
		$this->widget_name        = __( 'Recipe Categories', 'boo-recipes' );
		$this->settings           = array(
			'title'      => array(
				'type'  => 'text',
				'std'   => __( 'Recipe Categories', 'boo-recipes' ),
				'label' => __( 'Title', 'boo-recipes' ),
			),
			'number'     => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => __( 'Max Number of categories to show', 'boo-recipes' ),
			),
			'orderby'    => array(
				'type'    => 'select',
				'std'     => 'date',
				'label'   => __( 'Order by', 'boo-recipes' ),
				'options' => array(
					'count'   => __( 'Number of Recipes in Category', 'boo-recipes' ),
					'term_id' => __( 'ID', 'boo-recipes' ),
					'name'    => __( 'Name', 'boo-recipes' ),
					/*//					'menu_order' => __( 'Order field in recipe edit', 'boo-recipes' ),
					//					'modified'  =>  __( 'Modified Date', 'boo-recipes' ),*/

				),
			),
			'order'      => array(
				'type'    => 'select',
				'std'     => 'desc',
				'label'   => _x( 'Order', 'Sorting order', 'boo-recipes' ),
				'options' => array(
					'asc'  => __( 'ASC', 'boo-recipes' ),
					'desc' => __( 'DESC', 'boo-recipes' ),
				),
			),
			'hide_empty' => array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Hide if no recipe in category?', 'boo-recipes' ),
			),

		);

//		WP_Widget::__construct('boorecipe-widget-recipes',$this->widget_name , $this->settings);
		parent::__construct();

	}

	function widget( $args, $instance ) {

		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		$terms = $this->get_recipe_terms( $instance );

//		var_dump( $terms); die();

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$this->widget_start( $args, $instance );

			echo wp_kses_post( '<ul class="recipes_taxonomy_list_widget recipe_cats">' );


			// loop through all terms
			foreach ( $terms as $term ) {

				// Get the term link
				$term_link = get_term_link( $term );

				echo '<li><a href="' . esc_url( $term_link ) . '">' . $term->name . '</a></li>';
//
//				if( $term->count > 0 )
//					// display link to term archive
//					echo '<li><a href="' . esc_url( $term_link ) . '">' . $term->name .'</a></li>';
//
//				elseif( $term->count == 0 )
//					// display name
//					echo '<li>' . $term->name .'</li>';
			}

			echo wp_kses_post( '</ul>' );

			$this->widget_end( $args );
		}

		wp_reset_postdata();

		echo $this->cache_widget( $args, ob_get_clean() ); // WPCS: XSS ok.

	}

	/**
	 * Query the Recipes and return them.
	 *
	 * @param  array $instance Widget instance.
	 *
	 * @return array
	 */
	public function get_recipe_terms( $instance ) {
		$number     = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
		$orderby    = ! empty( $instance['orderby'] ) ? sanitize_title( $instance['orderby'] ) : $this->settings['orderby']['std'];
		$order      = ! empty( $instance['order'] ) ? sanitize_title( $instance['order'] ) : $this->settings['order']['std'];
		$hide_empty = ! empty( $instance['hide_empty'] ) ? true : false;


		$query_args = array(
			'taxonomy'   => 'recipe_category',
			'hide_empty' => $hide_empty,
			'orderby'    => $orderby,
			'order'      => $order,
			'number'     => $number,
		);


		switch ( $orderby ) {
			case 'count':
				$query_args['orderby'] = 'count';
				break;
			case 'term_id':
				$query_args['orderby'] = 'term_id';
				break;
			case 'name':
				$query_args['orderby'] = 'name';
				break;


			default:
				$query_args['orderby'] = 'count';
		}

		return get_terms( $query_args );
	}


}