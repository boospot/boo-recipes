<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get the meta
$meta = get_post_meta( $item->ID, 'boorecipe-recipe-meta', true );


// to accomodate qTranX / wp-multilang
if ( boorecipe_is_special_multilang_plugin_active() ) {
	$current_lang = boorecipe_get_current_language_code();
	$default_lang = boorecipe_get_default_language_code();
	$meta         = ( isset( $meta[ $current_lang ] ) && is_array( $meta[ $current_lang ] ) )
        ? $meta[ $current_lang ]
        : $meta[ $default_lang ];
}


do_action( 'boorecipe_before_single', $item, $meta );
?>

<div class="posttype-wrapper <?php echo implode( ' ', apply_filters( 'boorecipe_single_recipe_wrapper_classes', array() ) ); ?>">