<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'boorecipe_archive_wrap_start' ); // Even if there is no result

if ( have_posts() ) :

	/**
	 * @hooked        boorecipe_archive_loop_before
	 */
	do_action( 'boorecipe_archive_loop_before' );
	$archive_layout = apply_filters( 'boorecipe_set_archive_layout', boorecipe_get_default_options( 'recipe_archive_layout' ) );

	$archive_template = ( is_file( boorecipe_get_template( "archive-recipe-content-{$archive_layout}", 'archive' ) ) )
		? boorecipe_get_template( "archive-recipe-content-{$archive_layout}", 'archive' )
		: boorecipe_get_template( "archive-recipe-content-grid", 'archive' );

	while ( have_posts() ) : the_post();
		include $archive_template;
	endwhile;

	/**
	 * @hooked        boorecipe_single_before_loop
	 */
	do_action( 'boorecipe_archive_loop_after' );
else:
	do_action( 'boorecipe_archive_no_result' );
endif;
wp_reset_postdata();

do_action( 'boorecipe_archive_wrap_end' );