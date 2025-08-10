<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-sub-section recipe-key-points">
	<?php
	// Section icon first
	do_action( 'boorecipe_single_meta_key_point_icon', $item, $meta );
	// Then individual key point entries
	do_action( 'boorecipe_single_meta_key_point_style_1', $item, $meta );
	?>
</div>
