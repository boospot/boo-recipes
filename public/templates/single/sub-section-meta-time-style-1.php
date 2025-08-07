<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get the current recipe style
$recipe_style = function_exists('boorecipe_get_options_value') ? boorecipe_get_options_value('recipe_style') : 'style1';

// For Style 4, don't include the wrapper div since it's already wrapped in the template
if ($recipe_style === 'style4') {
	do_action( 'boorecipe_single_meta_time_style_1', $item, $meta );
} else {
?>
<div class="posttype-sub-section recipe-time-info"><?php
	do_action( 'boorecipe_single_meta_time_style_1', $item, $meta );
	?></div>
<?php
}
?>