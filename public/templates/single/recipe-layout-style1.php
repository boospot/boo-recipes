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
</div><!--    div.posttype-section-box-->

<div class="posttype-section recipe-body">
	<?php do_action( 'boorecipe_single_body_before', $item, $meta ); ?>
    <div class="recipe-main-body">
		<?php do_action( 'boorecipe_single_body', $item, $meta ); ?>
    </div>
	<?php do_action( 'boorecipe_single_body_after', $item, $meta ); ?>
</div><!--    div.recipe-body-->

<div class="posttype-section recipe-comments">
	<?php
	do_action( 'boorecipe_single_comments_before', $item, $meta );
	comments_template( '', true );
	do_action( 'boorecipe_single_comments_after', $item, $meta );
	?>
</div><!--    div.recipe-comments-->

<div class="posttype-section recipe-foot">
	<?php
	do_action( 'boorecipe_single_foot_before', $item, $meta );
	do_action( 'boorecipe_single_foot', $item, $meta );
	do_action( 'boorecipe_single_foot_after', $item, $meta );
	?>
</div><!--    div.recipe-foot-->