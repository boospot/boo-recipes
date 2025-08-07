<?php /** @noinspection PhpUndefinedVariableInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$itemprop_tag              = ( isset( $itemprop ) ) ? "itemprop='$itemprop'" : '';
$show_key_point_label      = ( $this->get_options_value( 'show_key_point_label' ) === 'yes' ) ? true : false;
$single_recipe_icon_size_2 = $this->get_options_value( 'single_recipe_icon_size_2' );
$show_icons                = ( $this->get_options_value( 'show_icons' ) === 'yes' ) ? true : false;
?>
<div class="taxonomy-<?php echo strtolower( sanitize_html_class( $taxonomy ) ); ?>">
    <span class="key-point-label">
        <?php if ( $show_icons ) : ?>
	        <?php echo Boorecipe_Globals::get_svg( $taxonomy, "icon-size-{$single_recipe_icon_size_2}" ); ?>
        <?php endif; ?>
	    <?php if ( $show_key_point_label ) : ?>
            <span class="subsection-label"><?php echo $taxonomy_label; ?></span>
	    <?php endif; ?>
     </span>
    <span <?php echo $itemprop_tag ?> class="subsection-value"><?php echo $taxonomy_terms; ?></span>
</div>
