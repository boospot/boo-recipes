<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<img src="<?php echo esc_url( get_avatar_url( $item->post_author ) ); ?>" width="25" height="25" class="avatar"
     alt="<?php the_author_meta( 'display_name', $item->post_author ); ?>"/>
