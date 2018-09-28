<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$blank_option = ( isset( $field_args['blank_option'] ) && $field_args['blank_option'] )
	? "<option value=''>{$this->get_options_value($field_args['blank_option']. '_label')}</option>"
	: '';

switch ( $field_args['type'] ) {

	case 'taxonomy':
		$option_markup = boorecipe_get_taxonomy_terms_options_markup( $field_args['id'] );

		break;

	case 'meta':

		$option_markup = boorecipe_get_meta_terms_options_markup( $field_args );

		break;

}
?>

<div class="search-form-field-cont">
    <label for="<?php echo $field_args['id'] ?>"><?php echo $this->get_options_value( $field_args['id'] . '_label' ) ?></label>
    <select name="<?php echo $field_args['id'] ?>"
            data-placeholder="<?php echo $this->get_options_value( $field_args['blank_option'] . '_label' ) ?>"
            class="select2 <?php echo $field_args['id'] ?>-filter">
		<?php echo $blank_option; ?>
		<?php echo $option_markup; ?>
    </select>
</div>