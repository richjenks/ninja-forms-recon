<?php

/**
 * Admin
 *
 * Adds the admin page
 */

namespace RichJenks\NFRecon;

class Admin extends Options {

	/**
	 * __construct
	 *
	 * Starts admin area magic
	 */

	public function __construct() {

		// Add Settings link to plugin page
		$this->add_settings_link();

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

		// Do options need saving?
		if ( isset( $_POST[ $this->prefix . 'save' ] ) ) {

			// Save options
			$this->set_options( $this->integrate_options( $_POST['fields'] ) );

			// Show notice
			add_action( 'admin_notices', function () { ?>
				<div class="updated"><p>Settings Saved</p></div>
			<?php } );

		}


	}

	/**
	 * add_settings_link
	 *
	 * Adds a settings link to plugin page for this plugin
	 */

	private function add_settings_link() {
		$plugin = plugin_basename( dirname( dirname( __FILE__ ) ) . '/index.php' );
		add_filter( 'plugin_action_links_' . $plugin , function ( $links ) {
			$links[] = '<a href="'. get_admin_url( null, 'admin.php?page=rj_nf_rc_options' ) .'">Settings</a>';
			return $links;
		} );
	}

	/**
	 * content
	 *
	 * @return string HTML for submenu content
	 */

	public function content() {
		$data = $this->get_options();
		require 'AdminView.php';
	}

}
