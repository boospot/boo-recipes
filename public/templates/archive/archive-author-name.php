<?php
/** @noinspection PhpUndefinedVariableInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<span class="recipe-archive-author">
    <?php include boorecipe_get_template( 'author-avatar', 'archive' ); ?>
    <span class="recipe-author-name"><?php echo $recipe_author_name; ?></span>
</span>
