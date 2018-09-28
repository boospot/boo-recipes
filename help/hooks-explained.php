<?php

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



if ( have_posts() ) :

	do_action( 'boorecipe_single_before_loop' );

	while ( have_posts() ) : the_post();

		do_action( 'boorecipe_before_single', $post, $meta );

		// 	div.posttype-wrapper

		do_action( 'boorecipe_single_main_before', $post, $meta );
		// main

		do_action( 'boorecipe_single_article_before_start' , $post, $meta );
		// article
		do_action( 'boorecipe_single_article_after_start' , $post, $meta );

		//div.media
		do_action( 'boorecipe_single_media_before', $post, $meta );
		do_action( 'boorecipe_single_media', $post, $meta );
		do_action( 'boorecipe_single_media_after', $post, $meta );
		//end: .media

		//div.head
		do_action( 'boorecipe_single_head_before', $post, $meta );
		do_action( 'boorecipe_single_head', $post, $meta );
		do_action( 'boorecipe_single_head_after', $post, $meta );
		//end: .head

		//div.meta
		do_action( 'boorecipe_single_meta_before', $post, $meta );
		do_action( 'boorecipe_single_meta', $post, $meta );
		do_action( 'boorecipe_single_meta_after', $post, $meta );
		//end: .meta

		//div.body
		do_action( 'boorecipe_single_body_before', $post, $meta );
		do_action( 'boorecipe_single_body', $post, $meta );
		do_action( 'boorecipe_single_body_after', $post, $meta );
		//end: .body

		//div.comments
		do_action( 'boorecipe_single_comments_before', $post, $meta );
		do_action( 'boorecipe_single_body', $post, $meta );
		do_action( 'boorecipe_single_comments_after', $post, $meta );
		//end: .comments

		//div.foot
		do_action( 'boorecipe_single_foot_before', $post, $meta );
		do_action( 'boorecipe_single_foot', $post, $meta );
		do_action( 'boorecipe_single_foot_after', $post, $meta );
		//end: .foot


		do_action( 'boorecipe_single_article_before_end' , $post, $meta );
		// end: article
		do_action( 'boorecipe_single_article_after_end' , $post, $meta );

		// end: main
		do_action( 'boorecipe_single_main_after', $post, $meta );

		// 	end: div.posttype-wrapper

		do_action( 'boorecipe-after-single', $post, $meta );

	endwhile;

	do_action( 'boorecipe_single_after_loop' );

endif;