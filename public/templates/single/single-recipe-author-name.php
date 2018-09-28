<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<span class="recipe-author-name-box">
    <?php if ( $meta['is_external_author'] !== 'yes' ): ?>
        <span class="recipe-author-avatar">
        <?php include boorecipe_get_template( 'author-avatar', 'archive' ); ?>
    </span>
    <?php endif; ?>
    <span class="recipe-author-name" itemprop="author"><?php echo $recipe_author_with_link; ?></span>
</span>
