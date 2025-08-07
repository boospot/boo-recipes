<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$recipe_author_link_label = $this->get_options_value( 'author_link'."_label" );

$recipe_author_link_label = str_replace( '%author', '%s', $recipe_author_link_label );

$author_id = $item->post_author;

// To adjust query in URL for different permalink structure
$query_separator = ( get_option( 'permalink_structure' ) ) ? '?' : '&';

$link_label = sprintf( $recipe_author_link_label, get_the_author_meta( 'display_name', $author_id ) );

?>
<div class="recipe-author-box">
    <div class="recipe-author-img">
		<?php echo get_avatar( get_the_author_meta( 'email', $author_id ), '100' ); ?>
    </div>
    <div class="recipe-author-desc">
        <h2 itemprop="author"><?php echo get_the_author_meta( 'display_name', $author_id ); ?></h2>
        <p><?php echo get_the_author_meta( 'description', $author_id ); ?></p>
        <div class="author-icons">
                <span class="before_author_recipes_link_action"><?php
	                do_action( 'boorecipe_before_author_recipes_link' );
	                ?></span><!--    recipe-before-meta-->
            <a class="author-all-recipes-link"
               href="<?php echo esc_url_raw( get_author_posts_url( $author_id ) . $query_separator . 'post_type=' . $item->post_type ); ?>"><?php echo $link_label; ?></a>
        </div>
    </div>


</div>