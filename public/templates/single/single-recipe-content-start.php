<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php do_action( 'boorecipe_single_main_before', $item, $meta ); ?>
    <main id="posttype-main" class="site-main" role="main">
        <?php do_action( 'boorecipe_single_article_before_start', $item, $meta ); ?>
            <article <?php post_class( implode( ' ', apply_filters( 'boorecipe_single_recipe_post_classes', array() ) ) ); ?> itemscope itemtype="http://schema.org/Recipe">
                <?php do_action( 'boorecipe_single_article_after_start', $item, $meta ); ?>