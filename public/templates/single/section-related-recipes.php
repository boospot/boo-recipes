<?php
/** @noinspection PhpUndefinedFieldInspection */
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$related_recipes_basis   = Boorecipe_Globals::get_options_value( 'related_recipes_basis' );
$related_recipes_label   = Boorecipe_Globals::get_options_value( 'related_recipes_label' );
$related_recipes_layout  = Boorecipe_Globals::get_options_value( 'related_recipes_layout' );
$related_recipes_limit   = Boorecipe_Globals::get_options_value( 'related_recipes_limit' );
$related_recipes_per_row = Boorecipe_Globals::get_options_value( 'related_recipes_per_row' );
$current_recipe_id       = $item->ID;
$post_taxonomy_term = '';
$terms_ids_array    = wp_get_post_terms( $item->ID, $related_recipes_basis, array( 'fields' => 'ids' ) );
if ( $terms_ids_array && ! is_wp_error( $terms_ids_array ) ) {
	$post_taxonomy_term = array_shift( $terms_ids_array );
}
// Build params
$relation_basis = $related_recipes_basis . "_ids";
?>
<div class="related-recipes-section">
    <h3 class="recipe-section-heading"><?php echo $related_recipes_label; ?></h3>
	<?php
	if ( $post_taxonomy_term ):
		echo do_shortcode( "[recipes_browse recipe_ids_exclude={$current_recipe_id} limit={$related_recipes_limit} recipe_archive_layout='{$related_recipes_layout}' {$relation_basis}={$post_taxonomy_term} recipes_per_row={$related_recipes_per_row}]" );
	endif;
	?></div><!--    div.related-recipes-->
