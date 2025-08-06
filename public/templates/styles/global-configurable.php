<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<style>
	/*Widgets*/

	form.boorecipe-search-form {
        background-color: <?php echo $form_bg_color; ?>;
	}

	form.boorecipe-search-form .search-form-field-cont .recipe-search-submit {
        background-color: <?php echo $form_button_bg_color; ?>;
		color: <?php echo $form_button_text_color; ?>;
	}

	.widget ul.recipes_list_widget li.recipe-list-item a img {
		width: <?php echo $recipe_widget_img_width; ?>px;
		height: <?php echo $recipe_widget_img_width; ?>px !important;
	}

	.widget ul.recipes_list_widget li.recipe-list-item {
		background-color: <?php echo $recipe_widget_bg_color; ?>;
	}

	<?php echo $custom_css; ?>

</style>
