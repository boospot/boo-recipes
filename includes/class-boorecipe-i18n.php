<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// if class already defined, bail out
if ( class_exists( 'Boorecipe_i18n' ) ) {
	return;
}

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Boorecipe
 * @subpackage Boorecipe/includes
 * @author     Rao Abid <raoabid491@gmail.com>
 */
class Boorecipe_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'boorecipe',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}


}
