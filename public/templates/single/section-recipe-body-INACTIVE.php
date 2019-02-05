<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-section recipe-body"><?php
	do_action( 'boorecipe_single_body_before', $item, $meta );
	?>
    <div class="recipe-main-body">
		<?php do_action( 'boorecipe_single_body', $item, $meta ); ?>
    </div>
	<?php
	do_action( 'boorecipe_single_body_after', $item, $meta );
	?></div><!--    div.recipe-body-->


