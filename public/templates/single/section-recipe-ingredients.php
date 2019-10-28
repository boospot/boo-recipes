<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ingredient_type = isset( $meta['ingredients_type'] ) ? sanitize_key( $meta['ingredients_type'] ) : '';
$meta_key        = ( 'wysiwyg' === $ingredient_type ) ? 'ingredients_wysiwyg' : 'ingredients';

do_action( 'boorecipe_single_body_ingredients_before' );
?>
    <div class="recipe-ingredients">
        <h3 class="recipe-section-heading"><?php echo $this->get_options_value( 'ingredients_label' ); ?></h3>
        <div class='select-items-cont'>
			<?php
			$ingredients = $meta[ $meta_key ];

			$ingredients      = str_ireplace( '<p>', '', $ingredients );
			$ingredients      = str_ireplace( '</p>', '', $ingredients );
			$ingredient_lines = preg_split( '/<br[^>]*>/i', nl2br( $ingredients ) );

			$section_start_identifier = "**";
			foreach ( $ingredient_lines as $item ) {
				$item = trim( $item );
				if ( ! empty( $item ) ) {
					if ( substr( wp_strip_all_tags( $item ), 0, strlen( $section_start_identifier ) ) === $section_start_identifier ) {
						$section_heading = str_replace( $section_start_identifier, "", $item );
						?>
                        <div class='ingredient-subsection'><?php echo $section_heading; ?></div>
						<?php
					} else {
						?>
                        <div class='select-item' itemprop='recipeIngredient'><?php echo $item; ?></div>
						<?php
					}
				}
			}
			?>
        </div><!--	.select-items-cont-->
    </div><!--    div.recipe-ingredients-->
<?php do_action( 'boorecipe_single_body_ingredients_after' ); ?>