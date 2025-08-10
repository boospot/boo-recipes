<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-sub-section recipe-taxonomy">
	<?php
	// Section icon first - only show once for the entire section
	do_action( 'boorecipe_single_meta_taxonomy_icon', $item, $meta );
	?>
	<div class="taxonomy-content">
		<?php
		// Then individual taxonomy entries without individual icons
		do_action( 'boorecipe_single_meta_taxonomy', $item, $meta );
		?>
	</div>
</div>
