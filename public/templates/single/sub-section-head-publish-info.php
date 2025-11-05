<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<span class="recipe-datePublished">
	<span class="recipe-show-date"><?php echo get_the_time( 'F j, Y', $item ); ?></span>
</span>
