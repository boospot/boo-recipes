<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Skip image slider for Style 4 - only show featured image
$current_recipe_style = function_exists('boorecipe_get_options_value') ? boorecipe_get_options_value('recipe_style') : 'style1';
if ( $current_recipe_style === 'style4' ) {
	return; // Don't show image slider for Style 4
}

$images_markup           = '';
$images_thumbnail_markup = '';
$images_array = rwmb_meta( Boorecipe_Globals::get_meta_prefix() . 'recipe_image_slider_items_attached' );

// Debug: Log image data (only in development)
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
	error_log( 'Recipe Slider Debug - Images Array: ' . print_r( $images_array, true ) );
}

// Only proceed if we have images
if ( ! empty( $images_array ) && is_array( $images_array ) ) {
	foreach ( $images_array as $image_id => $image ) {
		$main_image_src  = wp_get_attachment_image_src( $image_id, 'recipe_image' )[0];
		$thumb_image_src = wp_get_attachment_image_src( $image_id, 'recipe_slider_thumbnail' )[0];
		if ( ! empty( $main_image_src ) && ! empty( $thumb_image_src ) ) {
			$images_markup           .= "<li><img src='{$main_image_src}' /></li>";
			$images_thumbnail_markup .= "<li><img src='{$thumb_image_src}' /></li>";
		}
	}
}

// Only output slider HTML if we have images
if ( ! empty( $images_markup ) && ! empty( $images_thumbnail_markup ) ) {
?>
<div class="recipe-image-slider">
    <!-- Place somewhere in the <body> of your page -->
    <div id="slider-image-section" class="flexslider slider-image-section">
        <ul class="slides">
			<?php echo $images_markup; ?>
        </ul>
    </div>
    <div id="slider-thumbs-section" class="flexslider slider-thumbs-section">
        <ul class="slides">
			<?php echo $images_thumbnail_markup; ?>
        </ul>
    </div>
</div>
<?php
}