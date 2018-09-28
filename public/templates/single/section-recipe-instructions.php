<?php

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$meta_key        = 'directions';
$directions      = $meta[ $meta_key ];
$direction_lines = preg_split( '/<br[^>]*>/i', nl2br( $directions ) );
// Check if it contains sections
$section_start_identifier = "**";
$section_count            = 0;
$item_count               = 0;
?>
<div class="recipe-instructions">
    <h3 class="recipe-section-heading"><?php echo $this->get_options_value( $meta_key . '_label' ); ?></h3>
	<?php

	$html = "";

	$html .= "<div class='recipe-instructions-cont'>";

	foreach ( $direction_lines as $item ) {
		$item = trim( $item );
		if ( ! empty( $item ) ) {

			if ( substr( $item, 0, strlen( $section_start_identifier ) ) === $section_start_identifier ) {

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
