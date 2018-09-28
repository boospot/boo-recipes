<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_active_sidebar( apply_filters( 'boorecipe_aside_single_recipe_id', 'recipe-single-sidebar' ) ) ) {
	return;
}
?>
<aside id="secondary" role="complementary"
       class="<?php echo implode( ' ', apply_filters( 'boorecipe_aside_single_recipe_classes', array( 'widget-area' ) ) ); ?>">
	<?php dynamic_sidebar( apply_filters( 'boorecipe_aside_single_recipe_id', 'recipe-single-sidebar' ) ); ?>
</aside>