<?php

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$directions_type = isset( $meta['directions_type'] ) ? sanitize_key( $meta['directions_type'] ) : '';
$meta_key        = ( 'wysiwyg' === $directions_type ) ? 'directions_wysiwyg' : 'directions';

$directions = $meta[ $meta_key ];
// Remove paragraph tags
$directions = str_ireplace( '<p>', '', $directions );
$directions = str_ireplace( '</p>', '', $directions );
// convert to array
$direction_lines = preg_split( '/<br[^>]*>/i', nl2br( $directions ) );
// Check if it contains sections
$section_start_identifier = "**";
$section_count            = 0;
$item_count               = 0;
?>
<?php do_action( 'boorecipe_single_body_instruction_before' ); ?>
    <div class="recipe-instructions">
        <h3 class="recipe-section-heading"><?php echo $this->get_options_value( 'directions_label' ); ?></h3>
		<?php

		$html = "";

		$html .= "<div class='recipe-instructions-cont'>";

		foreach ( $direction_lines as $item ) {
			$item = trim( $item );
			if ( ! empty( $item ) ) {

				if ( substr( wp_strip_all_tags( $item ), 0, strlen( $section_start_identifier ) ) === $section_start_identifier ) {

					$section_heading = str_replace( $section_start_identifier, "", $item );

					// if it is not first section, close the ol
					if ( $section_count == 0 ) {
						$html .= "<div class='instructions-subsection'>{$section_heading}</div>";
						$html .= "<ol class='instructions-list' type='1'>";

					} else {
						$html .= "</ol>";
						$html .= "<div class='instructions-subsection'>{$section_heading}</div>";
						$html .= "<ol class='instructions-list' type='1'>";

					}

					$section_count ++;
					// Break the look and continue to next item
//			    continue;
				} else {
					// if it is not a section, then its an instruction:

					if ( $item_count == 0 ) {
						$html .= "<ol class='instructions-list' type='1'>";
					}

					$html .= "<li class='recipe-single-instruction'>";
					$html .= "<span class='instruction-text' itemprop='recipeInstructions'>";
					$html .= $item;
					$html .= "</span>";
					$html .= "</li>";

				}

				$item_count ++;
			}
		}
		$html .= "</ol><!-- .instructions-list -->";


		$html .= "</div>";

		echo $html;
		?>
    </div><!--  end of div.recipe-instructions-->
<?php do_action( 'boorecipe_single_body_instruction_after' ); ?>