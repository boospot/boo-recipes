<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$meta = get_post_meta( $post->ID, 'boorecipe-recipe-meta', true );

$archive_card_classes = implode(' ', apply_filters('boorecipe_filter_archive_recipe_card_classes' , array('recipe-card')));
?>

<article class="<?php echo $archive_card_classes; ?>">
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="recipe-link">
		<?php do_action( 'boorecipe_archive_recipe_media', $post ); ?>
        <div class="recipe-card-content">
	        <?php do_action( 'boorecipe_archive_recipe_content', $post, $meta ); ?>
            <div class="recipe-keypoints"><?php do_action( 'boorecipe_archive_recipe_key_points', $post, $meta );
            ?></div><!-- .recipe-keypoints -->
        </div><!-- .card-content -->
    </a><!-- .recipe-link-->
</article><!-- .recipe-card-->




