<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<span class="recipe-author-name-box">
    <?php if ( ! $meta['is_external_author'] ): ?>
        <span class="recipe-author-avatar">
        <?php include boorecipe_get_template( 'author-avatar', 'archive' ); ?>
    </span>
    <?php else:

	    if ( isset( $meta['external_author_image'] ) ):

		    printf( '<span class="recipe-author-avatar external-author-avatar">%s</span>',
			    wp_get_attachment_image( $meta['external_author_image'], 'thumbnail' )
		    );

	    endif;

	    ?>
    <?php endif; ?>

    <span class="recipe-author-name" itemprop="author"><?php echo $recipe_author_with_link; ?></span>
</span>
