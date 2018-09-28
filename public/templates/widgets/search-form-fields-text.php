<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$field_value = isset( $_GET[ $field_args['id'] ] ) ? sanitize_text_field( $_GET[ $field_args['id'] ] ) : '';

$placeholder = isset( $field_args['placeholder'] )
	? "placeholder='" . sanitize_text_field( $field_args['placeholder'] ) . "'"
	: '';

?>
<div class="search-form-field-cont">
    <label for="<?php echo $field_args['id'] ?>"><?php echo $this->get_options_value( $field_args['id'] . '_label' ) ?></label>
    <input type="text" <?php echo $placeholder; ?> name="<?php echo $field_args['id'] ?>"
           value="<?php echo $field_value ?>">
</div>

