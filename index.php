<?php

/**
 * Plugin Name: Ninja Forms - Recon
 * Plugin URI: https://bitbucket.org/richjenks/nf-moar-data
 * Description: When you need to know more about your users, do some recon!
 * Version: 1.0
 * Author: Rich Jenks <rich@richjenks.com>
 * Author URI: http://richjenks.com
 * License: GPL2
 */

namespace RichJenks\NFRecon;

// Required files
require_once 'inc/Plugin.php';
require_once 'inc/Options.php';
require_once 'inc/Admin.php';
require_once 'inc/Fields.php';

// Add admin page if back-end
if ( is_admin() ) new Admin;

// add_action( 'admin_menu', function() {
// 	global $menu;
// 	var_dump( $menu );
// }, 9999 );

// add_action( 'ninja_forms_display_pre_init', function() {

// 	global $ninja_forms_loading;
// 	global $ninja_forms_processing;

// 	// Either form is being displayed or success page is
// 	if ( isset( $ninja_forms_loading ) ) {
// 		$form_name = $ninja_forms_loading->data['form']['form_title'];
// 	} elseif ( isset( $ninja_forms_processing ) ) {
// 		$form_name = $ninja_forms_processing->data['form']['form_title'];
// 	}

// 	add_action( 'ninja_forms_display_fields', function() use ( $form_name ) {
// 		echo '<input type="hidden" name="_form_name" value="' . $form_name . '">';
// 	} );

// } );