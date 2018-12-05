<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
//var_dump( $meta); die();
//var_dump( get_post_meta( get_the_ID(),  'boorecipe_short_description', true )); die();
?>
<div class="posttype-sub-section recipe-description" itemprop="description"><p><?php
//		echo get_post_meta( get_the_ID(),  'boorecipe_short_description', true );
        echo $meta['short_description'];
		?></p></div>
