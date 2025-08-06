<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$excerpt = ( isset( $meta['list_excerpt'] ) ) ? $meta['list_excerpt'] : '';

if ( empty( $excerpt ) ) {
	$excerpt = get_the_excerpt();
}

if(! empty($excerpt)){
    ?>
        <div class="recipe-archive-excerpt"><p><?php echo $excerpt; ?></p></div>
    <?php
}
?>
