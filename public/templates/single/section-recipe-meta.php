<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$meta_classes = apply_filters( 'boorecipe_recipe_meta_classes', array( 'posttype-section', 'recipe-meta' ) );
?>
<div class="<?php echo implode( ' ', $meta_classes ); ?>"><?php
	do_action( 'boorecipe_single_meta_before', $item, $meta );
	do_action( 'boorecipe_single_meta', $item, $meta );
	do_action( 'boorecipe_single_meta_after', $item, $meta );
	?></div>