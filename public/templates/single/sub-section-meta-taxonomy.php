<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-sub-section recipe-taxonomy">
	<?php
	// Section icon first
	do_action( 'boorecipe_single_meta_taxonomy_icon', $item, $meta );
	// Then individual taxonomy entries
	do_action( 'boorecipe_single_meta_taxonomy', $item, $meta );
	?>
</div>
