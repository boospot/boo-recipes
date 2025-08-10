<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-sub-section recipe-key-points">
	<?php
	// Section icon first - only show once for the entire section
	do_action( 'boorecipe_single_meta_key_point_icon', $item, $meta );
	// Then individual key point entries without individual icons
	do_action( 'boorecipe_single_meta_key_point_style_1', $item, $meta );
	?>
</div>
