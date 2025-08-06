<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$boorecipe_single_recipe_layout = boorecipe_get_options_value( 'recipe_style' );

// For All Recipe Style
include boorecipe_get_template( 'single-recipe-content-start', 'single' );


include boorecipe_get_template( 'recipe-layout-' . $boorecipe_single_recipe_layout, 'single' );

//	include boorecipe_get_template( 'section-recipe-header', 'single' );
//	include boorecipe_get_template( 'section-recipe-body', 'single' );
//	include boorecipe_get_template( 'section-recipe-comments', 'single' );
//	include boorecipe_get_template( 'section-recipe-foot', 'single' );


// For All Recipe Style
include boorecipe_get_template( 'single-recipe-content-end', 'single' );