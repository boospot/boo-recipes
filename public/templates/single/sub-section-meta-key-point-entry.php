<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$itemprop = ( isset( $itemprop ) ) ? "itemprop='{$itemprop}'" : "";
?>
<div class="recipe-<?php echo $key_point; ?>">
	<?php if ( $this->get_options_value('show_key_point_label') === 'yes' ) : ?>
        <span class="subsection-label"><?php echo $key_point_label; ?></span>
	<?php endif; ?>
    <span class="subsection-value" <?php echo $itemprop ?>><?php echo $key_point_value ?></span>
</div>

