<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="archive-key-point key-point-<?php echo $key_point; ?>"><?php if ( $this->get_options_value( 'show_archive_key_point_labels' ) === 'yes' ): ?>
        <span class="recipe-archive-key"><?php echo $key_point_label; ?></span>
	<?php endif; ?>
	<?php if ( $this->get_options_value( 'show_archive_key_point_icons' ) === 'yes' ): ?>
        <span class="recipe-archive-icon"><?php echo Boorecipe_Globals::get_svg( $key_point, 'icon-size-' . $this->get_options_value( 'archive_key_point_icon_size' ) ); ?></span>
	<?php endif; ?>
    <span class="recipe-archive-key-value"><?php echo $key_point_value; ?></span>
</div>
