<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$svg_size_class = ( isset( $svg_class ) ? $svg_class : 'icon-size-' . boorecipe_get_default_options( 'layout_switcher_icon_size' ) );
?>
<div class="recipe-layout-selector-cont">
    <span class="recipe-layout-switcher grid-icon recipes-go-grid"><?php echo Boorecipe_Globals::get_svg( 'grid', $svg_size_class ); ?></span>
    <span class="recipe-layout-switcher list-icon recipes-go-list"><?php echo Boorecipe_Globals::get_svg( 'list', $svg_size_class ); ?></span>
</div>