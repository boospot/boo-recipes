<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get the meta
//$meta = get_post_meta( $item->ID, 'boorecipe-recipe-meta', true );

$meta = Boorecipe_Globals::get_recipe_meta( $item->ID );

do_action( 'boorecipe_before_single', $item, $meta );
?>

<div class="posttype-wrapper <?php echo implode( ' ', apply_filters( 'boorecipe_single_recipe_wrapper_classes', array() ) ); ?>">