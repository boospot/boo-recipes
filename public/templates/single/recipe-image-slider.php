<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$images_markup           = '';
$images_thumbnail_markup = '';

$images_array = rwmb_meta( Boorecipe_Globals::get_meta_prefix() . 'recipe_image_slider_items_attached' );

//var_dump( $images_array); die();

foreach ( $images_array as $image_id => $image ) {

//	$main_image_src  = $image['full_url'];
//	$thumb_image_src = $image['url'];
	$main_image_src  = wp_get_attachment_image_src( $image_id, 'recipe_image' )[0];
	$thumb_image_src = wp_get_attachment_image_src( $image_id, 'recipe_slider_thumbnail' )[0];

	if ( ! empty( $main_image_src ) && ! empty( $main_image_src ) ) {
		$images_markup           .= "<li><img src='{$main_image_src}' /></li>";
		$images_thumbnail_markup .= "<li><img src='{$thumb_image_src}' /></li>";
	}
}
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