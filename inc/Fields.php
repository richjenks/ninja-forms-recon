<?php

/**
 * Fields
 *
 * Adds fields to forms
 */

namespace RichJenks\NFRecon;

// class Fields extends Options {

// 	public function __construct() {
// 		$this->add_field(  );
// 	}

// 	private function add_field( $label ) {
// 		add_action( 'init', function () {
// 			$args = array(
// 				'name' => 'User IP', // This will be the label of the field button in the back-end editor.
// 				'display_function' => 'collect_user_ip_display', // This function will be called when the form is rendered on the front-end.
// 				'sidebar' => 'template_fields', // This is the sidebar on the Field Settings tab that this field will show up in.
// 				'display_label' => false, // Since we're adding a hidden form, we don't want to show the label on the front-end.
// 				'display_wrap' => false, // Again, this is a hidden field, so we don't need the div wrapper that's normally output to the front-end.
// 			);

// 			if( function_exists( 'ninja_forms_register_field' ) ) {
// 				ninja_forms_register_field( 'user_ip', $args );
// 			}

// 		} );
// 	}

// }

// new Fields;

// Try adding a field, see how it's stored



// ---


// add_action( 'ninja_forms_display_pre_init', function() {

// 	global $ninja_forms_loading;
// 	global $ninja_forms_processing;

// 	// Either form is being displayed or success page is
// 	if ( isset( $ninja_forms_loading ) ) {
// 		$form_name = $ninja_forms_loading->data['form']['form_title'];
// 	} elseif ( isset( $ninja_forms_processing ) ) {
// 		$form_name = $ninja_forms_processing->data['form']['form_title'];
// 	}

// 	add_action( 'ninja_forms_display_open_form_tag', function() use ( $form_name ) {
// 		echo '<input type="text" name="recon_form_name" value="' . $form_name . '">';
// 	} );

// } );

add_action( 'ninja_forms_display_before_fields', function () {
	echo '<input type="text" value="Recon Value" name="recon_field">';
} );

// add_action( 'init', function () {
	// var_dump( Ninja_Forms() );
// }, 5 );

add_action( 'ninja_forms_post_process', function () {
	var_dump( $GLOBALS['ninja_forms_processing'] );
	// var_dump( $GLOBALS['ninja_forms_processing']->get_form_setting( 'sub_id' ) );
	// var_dump( $ninja_forms_processing->get_form_setting( 'sub_id' ) );
} );