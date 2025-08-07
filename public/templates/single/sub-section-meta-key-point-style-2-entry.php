<?php
/** @noinspection PhpUndefinedVariableInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$itemprop                  = ( isset( $itemprop ) ) ? "itemprop='{$itemprop}'" : "";
$show_key_point_label      = ( $this->get_options_value( 'show_key_point_label' ) === 'yes' ) ? true : false;
$show_icons                = ( $this->get_options_value( 'show_icons' ) === 'yes' ) ? true : false;
$single_recipe_icon_size_2 = $this->get_options_value( 'single_recipe_icon_size_2' );
?>
<div class="recipe-<?php echo $key_point; ?>">
    <span class="key-point-label">
        <?php if ( $show_icons ) : ?>
	        <?php echo Boorecipe_Globals::get_svg( $key_point, "icon-size-{$single_recipe_icon_size_2}" ); ?>
        <?php endif; ?>
	    <?php if ( $show_key_point_label ) : ?>
            <span class="subsection-label"><?php echo $key_point_label; ?></span>
	    <?php endif; ?>
    </span>

    <span class="subsection-value" <?php echo $itemprop ?>><?php echo $key_point_value ?></span>
</div>

