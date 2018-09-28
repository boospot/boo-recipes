<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php do_action( 'boorecipe_single_article_before_end', $item, $meta ); ?>
</article>
<?php do_action( 'boorecipe_single_article_after_end', $item, $meta ); ?>
</main>
<?php do_action( 'boorecipe_single_main_after', $item, $meta ); ?>