<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BoorecipeWidgetRecipes
 */
class BoorecipeWidgetRecipes extends Boorecipe_Widget_Master {

	/**
	 * BoorecipeWidgetRecipes constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'boorecipe widget_recipes';
		$this->widget_description = __( "A list of your recipes", 'boorecipe' );
		$this->widget_id          = 'boorecipe_recipes';
		$this->widget_name        = __( 'Recipes', 'boorecipe' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Recipes', 'boorecipe' ),
				'label' => __( 'Title', 'boorecipe' ),
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => __( 'Number of recipes to show', 'boorecipe' ),
			),

			'orderby' => array(
				'type'    => 'select',
				'std'     => 'date',
				'label'   => __( 'Order by', 'boorecipe' ),
				'options' => array(
					'date'          => __( 'Date', 'boorecipe' ),
					'comment_count' => __( 'Comment Count', 'boorecipe' ),
					'rand'          => __( 'Random (Slow Method)', 'boorecipe' ),
					'title'         => __( 'Title', 'boorecipe' ),
					'menu_order'    => __( 'Order field in recipe edit', 'boorecipe' ),
					'modified'      => __( 'Modified Date', 'boorecipe' ),

				),
			),
			'order'   => array(
				'type'    => 'select',
				'std'     => 'desc',
				'label'   => _x( 'Order', 'Sorting order', 'boorecipe' ),
				'options' => array(
					'asc'  => __( 'ASC', 'boorecipe' ),
					'desc' => __( 'DESC', 'boorecipe' ),
				),
			),
//			'hide_free'   => array(
//				'type'  => 'checkbox',
//				'std'   => 0,
//				'label' => __( 'Hide free recipes', 'boorecipe' ),
//			),
//			'show_hidden' => array(
//				'type'  => 'checkbox',
//				'std'   => 0,
//				'label' => __( 'Show hidden recipes', 'boorecipe' ),
//			),
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

		$recipes = $this->get_recipes( $instance );
		if ( $recipes && $recipes->have_posts() ) {
			$this->widget_start( $args, $instance );

			echo wp_kses_post( '<ul class="recipes_list_widget">' );

			while ( $recipes->have_posts() ) {
				$recipes->the_post();

				?>
                <li class="recipe-list-item">

                    <a href="<?php echo esc_url_raw( get_the_permalink() ); ?>">
                        <img src="<?php echo esc_url_raw( boorecipe_get_posttype_image_url( get_the_ID(), 'thumbnail' ) ); ?>"
                             alt="<?php echo sanitize_title_with_dashes( get_the_title() ); ?>"/>
                        <span class="widget-recipe-title"><?php the_title_attribute(); ?></span>
                    </a>


                </li>
				<?php
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
	 * @return WP_Query
	 */
	public function get_recipes( $instance ) {
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
//		$show                        = ! empty( $instance['show'] ) ? sanitize_title( $instance['show'] ) : $this->settings['show']['std'];
		$orderby = ! empty( $instance['orderby'] ) ? sanitize_title( $instance['orderby'] ) : $this->settings['orderby']['std'];
		$order   = ! empty( $instance['order'] ) ? sanitize_title( $instance['order'] ) : $this->settings['order']['std'];

		//		$recipe_visibility_term_ids = wc_get_product_visibility_term_ids();

		// Skip the current post for the loop
		$current_page_id = get_the_ID();

		$exclude_ids = array( $current_page_id );

		$query_args = array(
			'posts_per_page' => $number,
			'post_status'    => 'publish',
			'post_type'      => 'boo_recipe',
			'no_found_rows'  => 1,
			'order'          => $order,
			'meta_query'     => array(),
			'tax_query'      => array(
				'relation' => 'AND',
			),
			'post__not_in'   => $exclude_ids,
		); // WPCS: slow query ok.


		switch ( $orderby ) {
			case 'date':
				$query_args['orderby'] = 'date';
				break;
			case 'comment_count':
				$query_args['orderby'] = 'comment_count';
				break;
			case 'rand':
				$query_args['orderby'] = 'rand';
				break;
			case 'title':
				$query_args['orderby'] = 'title';
				break;
			case 'menu_order':
				$query_args['orderby'] = 'menu_order';
				break;
			case 'modified':
				$query_args['orderby'] = 'modified';
				break;


			default:
				$query_args['orderby'] = 'date';
		}

		return new WP_Query( $query_args );
	}


}