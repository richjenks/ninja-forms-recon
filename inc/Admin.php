<?php

/**
 * Admin
 *
 * Adds the admin page
 */

namespace RichJenks\NFMoarData;

class Admin extends Plugin {

	/**
	 * __construct
	 *
	 * Adds submenu page
	 */

	public function __construct() {
		add_action( 'admin_menu', function() {
			add_submenu_page(
				'ninja-forms',            // Parent slug
				'Moar Data',              // Page title
				'Moar Data',              // Menu title
				apply_filters(            // Capability
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
