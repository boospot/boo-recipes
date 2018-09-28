<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-section recipe-meta"><?php
	do_action( 'boorecipe_single_meta_before', $item, $meta );
	do_action( 'boorecipe_single_meta', $item, $meta );
	do_action( 'boorecipe_single_meta_after', $item, $meta );
	?></div><!--    div.recipe-meta-->