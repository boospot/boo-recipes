<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * The following @params required for  this file to work
 * $item ($post)
 * $title (after passing through urlencode() function)
 * $excerpt
 * $featured_image_url
 *
 */

$excerpt_encoded = urlencode( $excerpt . PHP_EOL . PHP_EOL );

$link_to_share = $excerpt_encoded . esc_url_raw( get_the_permalink( $item->ID ) );

$icon_facebook   = Boorecipe_Globals::get_svg( 'facebook', 'icon-size-16' );
$icon_twitter    = Boorecipe_Globals::get_svg( 'twitter', 'icon-size-16' );
$icon_pinterest  = Boorecipe_Globals::get_svg( 'pinterest', 'icon-size-16' );
$icon_linkedin   = Boorecipe_Globals::get_svg( 'linkedin', 'icon-size-16' );
$icon_email      = Boorecipe_Globals::get_svg( 'email', 'icon-size-16' );
$icon_googleplus = Boorecipe_Globals::get_svg( 'googleplus', 'icon-size-16' );
?>
<div class="posttype-sub-section recipe-share-buttons">
    <div class="share-buttons-cont">
        <a class="share-link-button facebook-share"
           target="_blank"
           href="<?php echo "https://www.facebook.com/sharer/sharer.php?u=" . esc_url_raw( get_the_permalink( $item->ID ) ); ?>">
            <span class="share-icon"><?php echo $icon_facebook; ?></span>
            <span class="share-text"><?php echo _x( 'Share', 'facebook, linkedin etc', 'boorecipe' ); ?></span>
        </a>
        <a class="share-link-button twitter-share" target="_blank"
           href="<?php echo "https://twitter.com/home?status=" . $link_to_share; ?>">
            <span class="share-icon"><?php echo $icon_twitter; ?></span>
            <span class="share-text"><?php echo _x( 'Tweet', 'twitter tweet', 'boorecipe' ); ?></span>
        </a>
        <a class="share-link-button pinterest-share" target="_blank"
           href="<?php echo "https://pinterest.com/pin/create/button/?url=" . esc_url_raw( get_the_permalink( $item->ID ) ) . "&media=" . $featured_image_url . "&description=" . $title; ?>">
            <span class="share-icon"><?php echo $icon_pinterest; ?></span>
            <span class="share-text"><?php echo _x( 'Save', 'pinterest etc', 'boorecipe' ); ?></span>
        </a>
        <a class="share-link-button linkedin-share"
           target="_blank"
           href="<?php echo "https://www.linkedin.com/shareArticle?url=" . esc_url_raw( get_the_permalink( $item->ID ) ) . "&title=" . $title . "&summary=" . $excerpt_encoded; ?>">
            <span class="share-icon"><?php echo $icon_linkedin; ?></span>
            <span class="share-text"><?php echo _x( 'Share', 'facebook, linkedin etc', 'boorecipe' ); ?></span>
        </a>
        <a class="share-link-button google-plus-share"
           target="_blank"
           href="<?php echo "https://plus.google.com/share?url=" . esc_url_raw( get_the_permalink( $item->ID ) ); ?>">
            <span class="share-icon"><?php echo $icon_googleplus; ?></span>
            <span class="share-text"><?php echo _x( 'Share', 'facebook, linkedin etc', 'boorecipe' ); ?></span>
        </a>
        <a class="share-link-button email-share" target="_blank"
           href="mailto:?&subject=<?php echo get_the_title( $item->ID ) . " recipe"; ?>&body=<?php echo $excerpt . PHP_EOL . PHP_EOL . "%0A%0A" . esc_url_raw( get_the_permalink( $item->ID ) ); ?>">
            <span class="share-icon"><?php echo $icon_email; ?></span>
            <span class="share-text"><?php echo _x( 'Email', 'Send Email', 'boorecipe' ); ?></span>
        </a>

		<?php do_action( 'boorecipe_share_buttons', $item, $title, $excerpt, $featured_image_url ); ?>
    </div>
</div><!--    .recipe-share-buttons-->
