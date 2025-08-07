<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-sub-section recipe-meta <?php echo implode( ' ', apply_filters( 'boorecipe_single_recipe_layout_class', array() ) );?>"><?php
	do_action( 'boorecipe_single_meta_key_point_style_2', $item , $meta );
	?></div>
