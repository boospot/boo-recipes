<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Validate field_args
if ( ! is_array( $field_args ) || ! isset( $field_args['id'] ) || ! is_string( $field_args['id'] ) ) {
	return;
}
$field_id = sanitize_key( $field_args['id'] );
$field_value = '';
if ( isset( $_GET[ $field_id ] ) && is_string( $_GET[ $field_id ] ) ) {
	$field_value = sanitize_text_field( $_GET[ $field_id ] );
}
$placeholder = '';
if ( isset( $field_args['placeholder'] ) && is_string( $field_args['placeholder'] ) ) {
	$placeholder = "placeholder='" . esc_attr( $field_args['placeholder'] ) . "'";
}
$field_label = '';
if ( method_exists( $this, 'get_options_value' ) ) {
	$field_label = $this->get_options_value( $field_id . '_label' );
}
?>
<div class="search-form-field-cont">
    <label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $field_label ); ?></label>
    <input type="text" <?php echo $placeholder; ?> name="<?php echo esc_attr( $field_id ); ?>"
           value="<?php echo esc_attr( $field_value ); ?>">
</div>
