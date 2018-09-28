<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php do_action( 'boorecipe_recipe_single_aside', $item, $meta ); ?>
    </div><!--posttype-wrapper-->
<?php do_action( 'boorecipe-after-single', $item, $meta ); ?>