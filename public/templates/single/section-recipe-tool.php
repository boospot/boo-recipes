<?php
/** @noinspection PhpUndefinedFieldInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$terms_ids_array = wp_get_post_terms( $item->ID, 'recipe_tool', array( 'fields' => 'ids' ) );
// Check if wp_get_post_terms returned an error
if ( is_wp_error( $terms_ids_array ) || empty( $terms_ids_array ) ) {
	return null;
}
?>
<div class="recipe-tool-section">
    <h3 class="recipe-section-heading"><?php echo Boorecipe_Globals::get_options_value( 'recipe_tool_label' ); ?></h3>
	<?php
	$enable_images = Boorecipe_Globals::get_options_value( 'show_recipe_tool_img' );
	?>
    <div class="recipe-tools-list <?php echo ( 'yes' === $enable_images ) ? 'tools-images' : ''; ?>">
		<?php
		foreach ( $terms_ids_array as $term_id ) {
			$term = get_term( $term_id );
			// Skip if term doesn't exist
			if ( ! $term || is_wp_error( $term ) ) {
				continue;
			}
			$override_url = get_term_meta( $term_id, 'override_url', true );
			if ( $override_url ) {
				$term_link = esc_url_raw( $override_url );
				$target    = '_blank';
			} else {
				$term_link = get_term_link( $term );
				// Check if get_term_link returned an error
				if ( is_wp_error( $term_link ) ) {
					$term_link = '#';
					$target    = '_top';
				} else {
					$target    = '_top';
				}
			}
			if ( 'yes' === $enable_images ):
				$image_id = get_term_meta( $term_id, 'featured_image', true );
				if ( ! $image_id ) {
					$image_id = Boorecipe_Globals::get_options_value( 'recipe_tool_default_img_url' );
				}
				$image_html = wp_get_attachment_image( $image_id, 'thumbnail' );
				if ( ! $image_html ) {
					$image_html = sprintf( '<img src="%s" alt="%s" />',
						boorecipe_default_taxonomy_image( 'cooking_method' ),
						$term->name
					);
				}
				printf( '<a href="%s" title="%s"  class="recipe-tool" target="%s">%s
                                    <span class="recipe-tool-title">%s</span>
                                </a>',
					$term_link,
					$term->name,
					$target,
					$image_html,
					$term->name
				);
			else:
				printf( '<a href="%s" title="%s"  class="recipe-tool" target="%s">
                                    <span class="recipe-tool-title">%s</span>
                                </a>',
					$term_link,
					$term->name,
					$target,
					$term->name
				);
			endif;
		}
		?></div>
</div><!--    div.recipe-tool-sections-->
