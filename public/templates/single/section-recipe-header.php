<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class='posttype-section-box'>
	<?php include boorecipe_get_template( 'section-recipe-media', 'single' ); ?>
    <div class="posttype-section-sub-box">
		<?php include boorecipe_get_template( 'section-recipe-head', 'single' ); ?>
		<?php include boorecipe_get_template( 'section-recipe-meta', 'single' ); ?>
    </div>
</div>
