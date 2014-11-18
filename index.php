<?php

/**
 * Plugin Name: Ninja Forms - Post Form Name
 * Plugin URI: https://github.com/richjenks/wp-nf-post-form-name
 * Description: Adds the hidden field _form_name to all forms
 * Version: 1.0
 * Author: Rich Jenks <rich@richjenks.com>
 * Author URI: http://richjenks.com
 * License: GPL2
 */

add_action( 'ninja_forms_display_pre_init', function() {

	global $ninja_forms_loading;
	global $ninja_forms_processing;

	// Either form is being displayed or success page is
	if ( isset( $ninja_forms_loading ) ) {
		$form_name = $ninja_forms_loading->data['form']['form_title'];
	} elseif ( isset( $ninja_forms_processing ) ) {
		$form_name = $ninja_forms_processing->data['form']['form_title'];
	}

	add_action( 'ninja_forms_display_fields', function() use ( $form_name ) {
		echo '<input type="hidden" name="_form_name" value="' . $form_name . '">';
	} );

} );