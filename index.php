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

add_action( 'ninja_forms_display_after_fields', function() {
	global $ninja_forms_loading;
	$form_name = $ninja_forms_loading->get_form_setting( 'form_title' );
	echo '<input type="hidden" name="_form_name" value="' . $form_name . '">';
} );