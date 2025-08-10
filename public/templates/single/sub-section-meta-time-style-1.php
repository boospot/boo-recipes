<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-sub-section recipe-time-info">
	<?php
	// Section icon first - only show once for the entire section
	do_action( 'boorecipe_single_meta_time_icon', $item, $meta );
	?>
	<div class="time-content">
		<?php
		// Then individual time entries without individual icons
		do_action( 'boorecipe_single_meta_time_style_1', $item, $meta );
		?>
	</div>
</div>