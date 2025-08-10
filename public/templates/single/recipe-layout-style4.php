<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
do_action( 'boorecipe_single_media_before', $item, $meta );
do_action( 'boorecipe_single_media', $item, $meta );
do_action( 'boorecipe_single_media_after', $item, $meta );
do_action( 'boorecipe_single_head_before', $item, $meta );
do_action( 'boorecipe_single_head', $item, $meta );
do_action( 'boorecipe_single_head_after', $item, $meta );
?>
    <div class="posttype-sub-section recipe-meta recipe-style4">
		<?php
		do_action( 'boorecipe_single_meta_before', $item, $meta );
		do_action( 'boorecipe_single_meta', $item, $meta );
		do_action( 'boorecipe_single_meta_after', $item, $meta );
		?>
    </div>
<?php
do_action( 'boorecipe_single_body_before', $item, $meta );
do_action( 'boorecipe_single_body', $item, $meta );
do_action( 'boorecipe_single_body_after', $item, $meta );
do_action( 'boorecipe_single_comments_before', $item, $meta );
comments_template('', true);
do_action( 'boorecipe_single_comments_after', $item, $meta );
do_action( 'boorecipe_single_foot_before', $item, $meta );
do_action( 'boorecipe_single_foot', $item, $meta );
do_action( 'boorecipe_single_foot_after', $item, $meta );