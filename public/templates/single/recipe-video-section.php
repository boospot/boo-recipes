<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$video_url = $meta['video_recipe_url'];
$is_local_video = boorecipe_is_local_media_url( $video_url );
if ( $is_local_video ) {
	// Its a local video so get the player ready
	$attachment_id = boorecipe_get_attachment_id( $video_url );
	if ( absint( $attachment_id ) > 0 ) {
		$meta_data = wp_get_attachment_metadata( $attachment_id );
		if ( isset( $meta_data['mime_type'] ) ) {
			$pos = strpos( $meta_data['mime_type'], 'video' );
			if ( $pos >= 0 ) {
				// We are sure its a video
				$video_attr_meta        = $meta_data;
				$video_attr_meta['src'] = $video_url;
//				Ref: https://developer.wordpress.org/reference/functions/wp_video_shortcode/
				echo wp_video_shortcode( $video_attr_meta );
			} else {
				// Console log Error
				echo boorecipe_console_log_message( __( 'Video URL provided is not a video actually. mime_type is not video.', 'boo-recipes' ), 'error' );
			}
		} else {
			// Console log Error
			echo boorecipe_console_log_message( __( 'Error getting Meta Data from Video URL.', 'boo-recipes' ), 'error' );
		}
	} else {
		// Console log Error
		echo boorecipe_console_log_message( __( 'Local Video URL is not found in the Wordpress Media!', 'boo-recipes' ), 'error' );
	}
} else {
	// Its not a local video, so try to embed
	?>
    <div class="responsive-video-container"><?php
		// Echo the embed code via oEmbed
		echo wp_oembed_get( $video_url ); ?>
    </div>
	<?php
}
