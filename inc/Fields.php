<?php

/**
 * Fields
 *
 * Adds fields to forms
 */

namespace RichJenks\NFRecon;

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