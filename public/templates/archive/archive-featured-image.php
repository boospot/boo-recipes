<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="recipe-img-cont">
	<?php
	if ( has_post_thumbnail( $item->ID ) && ! empty( get_the_post_thumbnail_url() ) ) {

		the_post_thumbnail(
			apply_filters( 'boorecipe_filter_archive_image_size', $this->get_options_value( 'grid_view_image_size' ) )
		);

	} else {
		?>

        <img class="recipe-default-img"
             src="<?php echo boorecipe_get_posttype_image_url( $item->ID ); ?>"
             alt="<?php the_title(); ?>"/>
		<?php
	} ?>
</div>
