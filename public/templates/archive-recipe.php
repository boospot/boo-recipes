<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Verify nonce if search form is submitted.
if ( boorecipe_is_search_form_submitted() ) {
	if ( ! wp_verify_nonce( $_GET['recipe_search_form'], 'recipe_search_form_submitted' ) ) {
		die( __( 'Security Validation Failed', 'boo-recipes' ) );
	}
}

/**
 * Let WordPress and the theme handle header/footer loading
 * This template only provides the archive content
 * The theme's template hierarchy will handle the page structure
 */
get_header();
?>
    <div class="wrap archive-recipe">
		<?php do_action( 'boorecipe_archive_wrap_start_inside' ); ?>
		<?php include boorecipe_get_template( "archive-recipe-loop", 'archive' ); ?>
		<?php do_action( 'boorecipe_archive_wrap_end_inside' ); ?>
    </div><!--.archive-recipe-->
<?php
get_footer();
?>