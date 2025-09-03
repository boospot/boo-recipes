<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$itemprop_tag              = ( isset( $itemprop ) ) ? "itemprop='$itemprop'" : '';
$show_key_point_label      = ( $this->get_options_value( 'show_key_point_label' ) === 'yes' ) ? true : false;
$show_icons                = ( $this->get_options_value( 'show_icons' ) === 'yes' ) ? true : false;
$single_recipe_icon_size   = $this->get_options_value( 'single_recipe_icon_size' );
?>
<div class="taxonomy-<?php echo strtolower( sanitize_html_class( $taxonomy ) ) ?>">
    <div class="key-point-label">
        <?php if ( $show_icons ) : ?>
            <?php echo Boorecipe_Globals::get_icon_font( $taxonomy, "icon-size-{$single_recipe_icon_size}" ); ?>
        <?php endif; ?>
        <?php if ( $show_key_point_label ) : ?>
            <div class="subsection-label"><?php echo $this->get_options_value( $taxonomy . '_label' ); ?></div>
        <?php endif; ?>
    </div>
    <span <?php echo $itemprop_tag ?> class="subsection-value"><?php echo $taxonomy_terms; ?></span>
</div>
