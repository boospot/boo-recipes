<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get the current recipe style
$recipe_style = function_exists('boorecipe_get_options_value') ? boorecipe_get_options_value('recipe_style') : 'style1';

// For Style 2, time is displayed in body_before section instead of meta section
if ($recipe_style === 'style2') {
	return; // Don't display time in meta section for Style 2
}

// For Style 3, time should appear after meta, so we return here and let body_before handle it
if ($recipe_style === 'style3') {
	return; // Don't display time in meta section for Style 3
}

// For Style 4, render outside the meta container in the layout template
if ($recipe_style === 'style4') {
    return;
} else {
?>
<div class="posttype-sub-section recipe-time-info">
	<?php
	// Icon first, then time entries
	do_action( 'boorecipe_single_meta_time', $item, $meta );
	?>
</div>
<?php
}
?>
