<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-sub-section recipe-publish-info">
	<?php
	/* Hooking into this action: author name and date */
	do_action( 'boorecipe_single_head_publish_info', $item, $meta );
	?>
</div>
