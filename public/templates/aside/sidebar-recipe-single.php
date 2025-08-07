<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Check if nutrition should be displayed on the side
$nutrition_side = boorecipe_get_options_value( 'nutrition_side' );
$show_nutrition = boorecipe_get_options_value( 'show_nutrition' );
// Show aside if there's an active sidebar OR if nutrition should be on the side
$has_sidebar = is_active_sidebar( apply_filters( 'boorecipe_aside_single_recipe_id', 'recipe-single-sidebar' ) );
$should_show_aside = $has_sidebar || ( $nutrition_side === 'yes' && $show_nutrition === 'yes' );
if ( ! $should_show_aside ) {
	return;
}
?>
<aside id="secondary" role="complementary"
       class="<?php echo implode( ' ', apply_filters( 'boorecipe_aside_single_recipe_classes', array( 'widget-area' ) ) ); ?>">
	<?php
	// Show sidebar widgets if active
	if ( $has_sidebar ) {
		dynamic_sidebar( apply_filters( 'boorecipe_aside_single_recipe_id', 'recipe-single-sidebar' ) );
	}

	// Nutrition content is handled by the proper action hook in single-recipe-end.php
	// No need to call do_action here as it causes duplication
	?>
</aside>
