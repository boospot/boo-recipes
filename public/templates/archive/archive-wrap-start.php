<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section
        class="recipe-cards recipes-layout-<?php echo implode( ' ', apply_filters( 'boorecipe_filter_archive_recipe_wrap_classes',
			array(
				'layout'  => boorecipe_get_default_options( 'recipe_archive_layout' ),
				'per_row' => boorecipe_get_default_options( 'recipes_per_row' ),
			) ) ); ?>">