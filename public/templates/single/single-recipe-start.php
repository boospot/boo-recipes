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
<?php
// Get the ingredient side setting
$ingredient_side = boorecipe_get_options_value( 'ingredient_side' );
$ingredient_class = ( $ingredient_side === 'yes' ) ? 'ingredients-by-side' : 'ingredients-in-row';
?>
<div class="posttype-wrapper <?php echo $ingredient_class; ?> <?php echo implode( ' ', apply_filters( 'boorecipe_single_recipe_wrapper_classes', array() ) ); ?>">