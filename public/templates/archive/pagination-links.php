<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="recipe-pagination">
	<?php

	$is_override_pagination_style = $this->get_options_value( 'override_theme_pagination_style' );

	if ( 'no' == $is_override_pagination_style ) {

		the_posts_pagination( array(
			'mid_size'  => 2,
			'prev_text' => __( '« prev', 'boo-recipes' ),
			'next_text' => __( 'next »', 'boo-recipes' ),
		) );

	} else {

	    global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) {
			echo paginate_links( array(
				'mid_size'  => 2,
				'prev_text' => __( '«' ),
				'next_text' => __( '»' ),
			) );
		}
	}

	?>
</div><!--recipe-pagination-->