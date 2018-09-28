<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$itemprop_tag         = ( isset( $itemprop ) ) ? "itemprop='$itemprop'" : '';
$show_key_point_label = ( $this->get_options_value( 'show_key_point_label' ) === 'yes' ) ? true : false;
?>
<div class="taxonomy-<?php echo strtolower( sanitize_html_class( $taxonomy ) ) ?>">
	<?php if ( $show_key_point_label ) : ?>
        <span class="subsection-label"><?php echo $this->get_options_value( $taxonomy . '_label' ); ?></span>
	<?php endif; ?>
    <span <?php echo $itemprop_tag ?> class="subsection-value"><?php echo $taxonomy_terms; ?></span>
</div>
