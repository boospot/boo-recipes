<?php

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$additional_notes = $meta[ $meta_key ];
?>
<div class="recipe-additional-notes">
    <h3 class="recipe-section-heading"><?php echo $this->get_options_value( $meta_key . '_label' ); ?></h3>
    <p><?php
		echo $meta['additional_notes'];
		?></p></div>