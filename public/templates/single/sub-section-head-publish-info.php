<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<span class="recipe-datePublished">
	<meta itemprop="datePublished" content="<?php echo get_the_time( 'Y-m-d', $item ); ?>">
	<span class="recipe-show-date"><?php echo get_the_time( 'F j, Y', $item ); ?></span>
</span>
