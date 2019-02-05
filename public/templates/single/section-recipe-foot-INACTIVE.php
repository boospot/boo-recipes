<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-section recipe-foot"><?php
	do_action( 'boorecipe_single_foot_before', $item, $meta );
	do_action( 'boorecipe_single_foot', $item, $meta );
	do_action( 'boorecipe_single_foot_after', $item, $meta );
	?></div><!--    div.recipe-foot-->