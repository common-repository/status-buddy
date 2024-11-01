<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://stackoverflow.com/users/1713495/maulik-kanani
 * @since      1.0.0
 *
 * @package    Status_Buddy
 * @subpackage Status_Buddy/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Status_Buddy
 * @subpackage Status_Buddy/includes
 * @author     Maulik Kanani <kanani.maulikb@gmail.com>
 */
class Status_Buddy_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'status-buddy',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
