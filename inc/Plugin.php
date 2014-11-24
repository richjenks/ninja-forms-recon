<?php

/**
 * Plugin
 *
 * Contains information for entire plugin
 */

namespace RichJenks\NFRecon;

class Plugin {

	/**
	 * @var string Prefix for global plugin strings, e.g. post types
	 */

	protected $prefix = 'rj_nf_rc_';

	/**
	 * add_settings_link
	 *
	 * Adds a settings link to plugin page for this plugin
	 */

	protected function add_settings_link() {
		$plugin = plugin_basename( dirname( dirname( __FILE__ ) ) . '/index.php' );
		add_filter( 'plugin_action_links_' . $plugin , function ( $links ) {
			$links[] = '<a href="'. get_admin_url( null, 'admin.php?page=rj_nf_rc_options' ) .'">Settings</a>';
			return $links;
		} );
	}

}
