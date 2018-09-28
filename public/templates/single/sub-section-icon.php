<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get svg class
$svg_size_class = ( isset( $svg_class ) ? $svg_class : 'icon-size-' . $this->get_options_value( 'single_recipe_icon_size' ) );
?>
<div class="subsection-icon">
	<?php echo Boorecipe_Globals::get_svg( $svg, $svg_size_class ) ?>
</div>
