<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-sub-section recipe-taxonomy-style-2"><?php
	do_action( 'boorecipe_single_meta_taxonomy', $post, $meta );
	?></div>
