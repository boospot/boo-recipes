<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-sub-section recipe-description" itemprop="description"><div><?php
		echo apply_filters('the_content', $meta['short_description']);
		?></div></div>
