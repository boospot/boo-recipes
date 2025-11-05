<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-sub-section recipe-description"><div><?php
		echo wp_kses_post( $meta['short_description'] );
		?></div></div>
