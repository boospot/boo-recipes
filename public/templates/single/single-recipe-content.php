<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
include boorecipe_get_template( 'single-recipe-content-start', 'single' );
include boorecipe_get_template( 'section-recipe-header', 'single' );
include boorecipe_get_template( 'section-recipe-body', 'single' );
include boorecipe_get_template( 'section-recipe-comments', 'single' );
include boorecipe_get_template( 'section-recipe-foot', 'single' );
include boorecipe_get_template( 'single-recipe-content-end', 'single' );