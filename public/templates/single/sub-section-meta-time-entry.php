<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$time_label = ( isset( $time_label ) ) ? $time_label : '';
$time_value = ( isset( $time_value ) ) ? $time_value : '';

// Recipe Time Options
if ( $meta['recipe_time_format'] === 'time_format_minutes' ) {
	$time_content_initial    = 'M';
	$time_content_unit_label = $this->get_options_value( 'time_unit_minutes_label' );
} else {
	$time_content_initial    = 'H';
	$time_content_unit_label = $this->get_options_value( 'time_unit_hours_label' );;
}

?>
<div class="recipe-<?php echo $itemprop; ?>">
    <span class="subsection-label"><?php echo $time_label; ?></span>
    <span itemprop="<?php echo $itemprop ?>" content="PT<?php echo $time_value . $time_content_initial ?>"
          class="subsection-value"><?php echo $time_value . " " . $time_content_unit_label; ?></span>
</div>
