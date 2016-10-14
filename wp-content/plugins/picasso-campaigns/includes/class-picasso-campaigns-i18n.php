<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/shamimmoeen/
 * @since      1.0.0
 *
 * @package    Picasso_Campaigns
 * @subpackage Picasso_Campaigns/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Picasso_Campaigns
 * @subpackage Picasso_Campaigns/includes
 * @author     Shamim Al Mamun <shamim.moeen@gmail.com>
 */
class Picasso_Campaigns_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'picasso-campaigns',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
