<?php
/** @noinspection PhpUndefinedFieldInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$terms_ids_array = wp_get_post_terms( $item->ID, 'cooking_method', array( 'fields' => 'ids' ) );

if ( empty( $terms_ids_array ) ) {
	return null;
}

?>
<div class="cooking-method-section">
    <h3 class="recipe-section-heading"><?php echo Boorecipe_Globals::get_options_value( 'cooking_method_label' ); ?></h3>
    <div class="cooking-method-list tools-images">
		<?php
		foreach ( $terms_ids_array as $term_id ) {

			$term = get_term( $term_id );

			$override_url = get_term_meta( $term_id, 'override_url', true );
			if ( $override_url ) {
				$term_link = esc_url_raw( $override_url );
				$target    = '_blank';
			} else {
				$term_link = get_term_link( $term );
				$target    = '_top';
			}

			$image_id   = get_term_meta( $term_id, 'featured_image', true );

			if ( ! $image_id ) {
				$image_id = Boorecipe_Globals::get_options_value( 'cooking_method_default_img_url' );
			}

			$image_html = wp_get_attachment_image( $image_id, 'thumbnail' );

			if ( ! $image_html ) {
				$image_html = sprintf( '<img src="%s" alt="%s" />',
					boorecipe_default_taxonomy_image( 'cooking_method' ),
					$term->name
				);
			}

			printf( '<a href="%s" title="%s"  class="cooking-method" target="%s">
                                %s<span itemprop="cookingMethod" class="cooking-method-title">%s</span>
                            </a>',
				$term_link,
				$term->name,
				$target,
				$image_html,
				$term->name
			);


		}
		?></div>
</div><!--    div.recipe-tool-sections-->

