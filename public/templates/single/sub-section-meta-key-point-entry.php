<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$itemprop = ( isset( $itemprop ) ) ? "itemprop='{$itemprop}'" : "";
$show_icons = ( $this->get_options_value( 'show_icons' ) === 'yes' ) ? true : false;
$single_recipe_icon_size = $this->get_options_value( 'single_recipe_icon_size' );
?>
<div class="recipe-<?php echo $key_point; ?>">
	<?php if ( $show_icons || $this->get_options_value('show_key_point_label') === 'yes' ) : ?>
        <div class="key-point-label">
            <?php if ( $show_icons ) : ?>
                <?php echo Boorecipe_Globals::get_icon_font( $key_point, "icon-size-{$single_recipe_icon_size}" ); ?>
            <?php endif; ?>
            <?php if ( $this->get_options_value('show_key_point_label') === 'yes' ) : ?>
                <div class="subsection-label"><?php echo $key_point_label; ?></div>
            <?php endif; ?>
        </div>
	<?php endif; ?>
    <span class="subsection-value" <?php echo $itemprop ?>><?php echo $key_point_value ?></span>
</div>
