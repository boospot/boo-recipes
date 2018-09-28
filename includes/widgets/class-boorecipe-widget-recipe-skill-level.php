<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BoorecipeWidgetRecipeSkillLevel
 */
class BoorecipeWidgetRecipeSkillLevel extends Boorecipe_Widget_Master {

	/**
	 * BoorecipeWidgetRecipeSkillLevel constructor.
	 */
	public function __construct() {

		$this->widget_cssclass    = 'boorecipe widget_recipe_skill_level';
		$this->widget_description = __( "A list of Recipe skill levels", 'boorecipe' );
		$this->widget_id          = 'boorecipe_recipe_skill_level';
		$this->widget_name        = __( 'Recipe Skill Level', 'boorecipe' );
		$this->settings           = array(
			'title'      => array(
				'type'  => 'text',
				'std'   => __( 'Recipe Skill Levels', 'boorecipe' ),
				'label' => __( 'Title', 'boorecipe' ),
			),
			'number'     => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => __( 'Max Number of skill levels to show', 'boorecipe' ),
			),
			'orderby'    => array(
				'type'    => 'select',
				'std'     => 'date',
				'label'   => __( 'Order by', 'boorecipe' ),
				'options' => array(
					'count'   => __( 'Number of Recipes in Skill Levels', 'boorecipe' ),
					'term_id' => __( 'ID', 'boorecipe' ),
					'name'    => __( 'Name', 'boorecipe' ),

				),
			),
			'order'      => array(
				'type'    => 'select',
				'std'     => 'desc',
				'label'   => _x( 'Order', 'Sorting order', 'boorecipe' ),
				'options' => array(
					'asc'  => __( 'ASC', 'boorecipe' ),
					'desc' => __( 'DESC', 'boorecipe' ),
				),
			),
			'hide_empty' => array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Hide if no recipe in skill levels?', 'boorecipe' ),
			),

		);

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

		$terms = $this->get_recipe_terms( $instance );


		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$this->widget_start( $args, $instance );

			echo wp_kses_post( '<ul class="recipes_taxonomy_list_widget recipe_skill_levels">' );


			// loop through all terms
			foreach ( $terms as $term ) {

				// Get the term link
				$term_link = get_term_link( $term );

				if ( $term->count > 0 ) // display link to term archive
				{
					echo '<li><a href="' . esc_url( $term_link ) . '">' . $term->name . '</a></li>';
				} elseif ( $term->count !== 0 ) // display name
				{
					echo '' . $term->name . '';
				}
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
			'taxonomy'   => 'skill_level',
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