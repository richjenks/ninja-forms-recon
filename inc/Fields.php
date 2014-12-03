<?php

/**
 * Fields
 *
 * Adds fields to forms
 */

namespace RichJenks\NFRecon;

class Fields extends Options {

	/**
	 * @var array Fields to add to form, $name => $value
	 */

	private $fields;

	/**
	 * @var array Posted data used by plugin
	 */

	private $data;

	/**
	 * __construct
	 *
	 * Add Actions so intensive tasks only run when required
	 */

	public function __construct() {

		// Add fields to form
		add_action( 'ninja_forms_display_pre_init', function () {

			// Construct array of fields and values
			$this->fields = $this->construct_fields( $this->get_options() );

			// Add fields to current form
			$this->add_fields( $this->fields );

		} );

		// When form submitted, add recon data
		add_action( 'ninja_forms_post_process', function () {
			$this->add_recon_data( $_POST );
		}, 11 );

	}

	/**
	 * construct_fields
	 *
	 * Constructs a list of field names to add to forms
	 *
	 * @param array $options Plugin options
	 * @return array Names of fields to add to form
	 */

	private function construct_fields( $options ) {

		$fields = array();

		// Check if field is enabled
		foreach ( $options as $category => $field ) {
			foreach ( $field as $option => $enabled ) {
				if ( $enabled ) {

					// Field is enabled, so construct field name
					$name = 'Recon[' . $category . '][' . $option . ']';

					// Find value for field
					switch ( $name ) {

						// Content
						case 'Recon[Content][Current URL]':
							$s = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ) ? 's' : '';
							$url = 'http' . $s . '://';
							$url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
							$fields[ $name ] = $url;
							break;

						// Google Campaign
						case 'Recon[Google Campaign][utm_source]':
							if ( isset( $_GET['utm_source'] ) )  $fields[ $name ] = $_GET['utm_source'];
							break;
						case 'Recon[Google Campaign][utm_medium]':
							if ( isset( $_GET['utm_medium'] ) )  $fields[ $name ] = $_GET['utm_medium'];
							break;
						case 'Recon[Google Campaign][utm_term]':
							if ( isset( $_GET['utm_term'] )  )   $fields[ $name ] = $_GET['utm_term'];
							break;
						case 'Recon[Google Campaign][utm_content]':
							if ( isset( $_GET['utm_content'] ) ) $fields[ $name ] = $_GET['utm_content'];
							break;
						case 'Recon[Google Campaign][utm_name]':
							if ( isset( $_GET['utm_name'] )  )   $fields[ $name ] = $_GET['utm_name'];
							break;

						// User
						case 'Recon[User][User Agent]':
							if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ); $fields[ $name ] = $_SERVER['HTTP_USER_AGENT'];
							break;
						case 'Recon[User][IP Address]':
							if ( isset( $_SERVER['REMOTE_ADDR'] ) ); $fields[ $name ] = $_SERVER['REMOTE_ADDR'];
							break;

					}

				}
			}
		}

		return $fields;

	}

	/**
	 * add_fields
	 *
	 * Adds fields to the current form
	 *
	 * @param array $fields Fields defined as $name => $value
	 */

	private function add_fields( $fields ) {
		foreach ( $fields as $name => $value ) {
			add_action( 'ninja_forms_display_before_fields', function () use ( $name, $value ) {
				echo '<input type="hidden" name="' . htmlentities( $name ) . '" value="' . htmlentities( $value ) . '">';
			} );
		}
	}

	/**
	 * add_recon_data
	 *
	 * Store Recon data from $_POST
	 *
	 * @param array $post $_POST data
	 */

	private function add_recon_data( $post ) {
		if ( isset( $post['Recon'] ) )  {
			global $ninja_forms_processing;
			$sub_id = $ninja_forms_processing->get_form_setting( 'sub_id' );
			Ninja_Forms()->sub( $sub_id )->update_meta( $this->pretty_prefix . 'data', json_encode( $post['Recon'] ) );
		}
	}

}
