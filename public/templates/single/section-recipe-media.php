<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-section recipe-media"><?php
	do_action( 'boorecipe_single_media_before', $item, $meta );
	do_action( 'boorecipe_single_media', $item, $meta );
	do_action( 'boorecipe_single_media_after', $item, $meta );
	?></div>

