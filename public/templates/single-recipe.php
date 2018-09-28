<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * The template for displaying all single recipe.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Boorecipe
 */

/**
 * Get a custom header-recipe.php file, if it exists.
 * Otherwise, get default header.
 */
get_header( 'recipe' );

if ( have_posts() ) :

	/**
	 * @hooked        boorecipe_single_before_loop
	 */
	do_action( 'boorecipe_single_loop_before' );

	while ( have_posts() ) : the_post();
		$item = $post;
		include boorecipe_get_template( 'single-recipe-start', 'single' );
		include boorecipe_get_template( 'single-recipe-content', 'single' );
		include boorecipe_get_template( 'single-recipe-end', 'single' );
	endwhile;

	/**
	 * @hooked        boorecipe_single_after_loop
	 */
	do_action( 'boorecipe_single_loop_after' );

else:

	do_action( 'boorecipe_single_no_result' );

endif;
/**
 * Get a custom footer-recipe.php file, if it exists.
 * Otherwise, get default footer.
 */
get_footer( 'recipe' );