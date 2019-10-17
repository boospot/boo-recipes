<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//var_dump_pretty( $archive_template);
/*
 * This file requires $archive_template be already defined where this is included.
 * $archive_template = path to the archive template
 */
do_action( 'boorecipe_archive_wrap_start' ); // Even if there is no result
if ( $loop->have_posts() ) :
	while ( $loop->have_posts() ) : $loop->the_post();
		$post = $loop->post;
		include $archive_template;
	endwhile;
else:
	do_action( 'boorecipe_archive_no_result' );
endif;
wp_reset_postdata();
do_action( 'boorecipe_archive_wrap_end' );