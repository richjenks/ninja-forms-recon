<?php

/**
 * Admin
 *
 * Adds the admin page
 */

namespace RichJenks\NFRecon;

class Admin extends Plugin {

	/**
	 * __construct
	 *
	 * Starts admin area magic
	 */

	public function __construct() {

		// Add Settings link to plugin page
		parent::add_settings_link();

		// Add submenu page
		add_action( 'admin_menu', function() {
			add_submenu_page(
				'ninja-forms',             // Parent slug
				'Recon',                   // Page title
				'Recon',                   // Menu title
				apply_filters(             // Capability
					'ninja_forms_admin_parent_menu_capabilities',
					'manage_options'
				),
				$this->prefix . 'options', // Submenu slug
				array( $this, 'content' )  // Callback
			);
		}, 100 );

	}

	/**
	 * content
	 *
	 * @return string HTML for submenu content
	 */

	public function content() { require 'AdminView.php'; }

}
