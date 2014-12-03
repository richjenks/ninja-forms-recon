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
				array( $this, 'options_content' )  // Callback
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

		// Are we editing a single submission?
		if ( isset( $_GET['post'] ) && get_post_type( $_GET['post'] ) === 'nf_sub' ) {
			$this->submission_content( $_GET['post'] );
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
	 * options_content
	 *
	 * @return string HTML for submenu content
	 */

	public function options_content() {
		$data = $this->get_options();
		require 'AdminView.php';
	}

	/**
	 * submission_content
	 *
	 * @param int $post Post ID
	 * @return string HTML for submission data content
	 */

	public function submission_content( $post ) {
		$data = get_post_meta( $_GET['post'], $this->pretty_prefix . 'data', true );
		if ( !empty( $data ) ) {
			$data = json_decode( $data, true );
			add_action( 'add_meta_boxes_nf_sub', function () use ( $data ) {
				\add_meta_box( $this->pretty_prefix . 'meta_box', 'Recon', function () use ( $data ) {
					require 'SubView.php';
				}, 'nf_sub' );
			} );

		}
	}

}
