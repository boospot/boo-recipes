<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$meta_key = 'ingredients';
?>
<div class="recipe-ingredients">
    <h3 class="recipe-section-heading"><?php echo $this->get_options_value( $meta_key . '_label' ); ?></h3>
    <div class='select-items-cont'>
		<?php
		$ingredients      = $meta[ $meta_key ];
		$ingredient_lines = preg_split( '/<br[^>]*>/i', nl2br( $ingredients ) );

		$section_start_identifier = "**";
		foreach ( $ingredient_lines as $item ) {
			$item = trim( $item );
			if ( ! empty( $item ) ) {
				if ( substr( $item, 0, strlen( $section_start_identifier ) ) === $section_start_identifier ) {
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