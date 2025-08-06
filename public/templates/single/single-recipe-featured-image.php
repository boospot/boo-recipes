<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="posttype-section recipe-img-cont">
    <img itemprop="image" src="<?php echo esc_url_raw( $featured_image ); ?>"
         alt="<?php echo esc_html( $item->post_title ); ?>"
         class="recipe-img"/>
</div><!--    div.recipe-img-cont-->

