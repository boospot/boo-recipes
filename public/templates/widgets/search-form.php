<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form class="boorecipe-search-form" action="<?php echo esc_url_raw( get_post_type_archive_link( 'boo_recipe' ) ); ?>">
	<?php
	// This will be verified on the recipe archive page as action of this form
	// get_post_type_archive_link( 'recipe' )
	wp_nonce_field( 'recipe_search_form_submitted', 'recipe_search_form' );

	do_action( 'boorecipe_widget_search_form_fields' );
	?>
    <div class="search-form-field-cont">
        <input type="submit" value="<?php echo $this->get_options_value( 'submit_button_label' ) ?>"
               class="recipe-search-submit" name="recipe_search">
    </div>
</form>