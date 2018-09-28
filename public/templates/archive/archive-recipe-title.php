<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="recipe-archive-title"><?php
	echo apply_filters( 'boorecipe_archive_title_args', esc_attr( strip_tags( get_the_title() ) ) );
	?></div>

