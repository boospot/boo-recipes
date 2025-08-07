<?php
/** @noinspection PhpUndefinedVariableInspection */
/** @noinspection PhpUndefinedMethodInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $loop->have_posts() ) :
	while ( $loop->have_posts() ) : $loop->the_post();
		$item = $loop->post;
//		$meta = get_post_meta( $item->ID, 'boorecipe-recipe-meta', true );
		$meta = Boorecipe_Globals::get_recipe_meta( $item->ID );
		?>
        <div class="posttype-wrapper <?php echo implode( ' ', apply_filters( 'boorecipe_single_recipe_wrapper_classes', array() ) ); ?>">
			<?php
			include boorecipe_get_template( 'single-recipe-content-start', 'single' );
			do_action( 'boorecipe_single_media_before', $item, $meta );
			do_action( 'boorecipe_single_media', $item, $meta );
			do_action( 'boorecipe_single_media_after', $item, $meta );

			do_action( 'boorecipe_single_head_before', $item, $meta );
			do_action( 'boorecipe_single_head', $item, $meta );
			do_action( 'boorecipe_single_head_after', $item, $meta );

			do_action( 'boorecipe_single_meta_before', $item, $meta );
			do_action( 'boorecipe_single_meta', $item, $meta );
			do_action( 'boorecipe_single_meta_after', $item, $meta );

			do_action( 'boorecipe_single_body_before', $item, $meta );
			do_action( 'boorecipe_single_body', $item, $meta );
			do_action( 'boorecipe_single_body_after', $item, $meta );
			include boorecipe_get_template( 'single-recipe-content-end', 'single' );

			?>
        </div><!--posttype-wrapper-->
	<?php
	endwhile;
else:
	echo __( 'No Recipe Found', 'boo-recipes' );
endif;
wp_reset_postdata();