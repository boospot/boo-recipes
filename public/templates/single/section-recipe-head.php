<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-section recipe-head"><?php
	do_action( 'boorecipe_single_head_before', $item, $meta );
	do_action( 'boorecipe_single_head', $item, $meta );
	do_action( 'boorecipe_single_head_after', $item, $meta );
	?></div>

