<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-section recipe-comments"><?php
	do_action( 'boorecipe_single_comments_before', $item, $meta );
	comments_template();
	do_action( 'boorecipe_single_comments_after', $item, $meta );
	?></div><!--    div.recipe-comments-->