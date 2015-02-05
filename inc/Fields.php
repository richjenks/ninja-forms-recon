<?php

/**
 * Fields
 *
 * Adds fields to forms and saves data to submissions
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
	 * @var int ID of current submission
	 */

	private $sub_id;

	/**
	 * __construct
	 *
	 * Add Actions so intensive tasks only run when required
	 */

	public function __construct() {

		// If referer not set, set it (for original referer)
		session_start();
		if ( !isset( $_SESSION['original_referer'] ) && isset( $_SERVER['HTTP_REFERER'] ) )
			$_SESSION['original_referer'] = $_SERVER['HTTP_REFERER'];

		// Add fields to form
		add_action( 'ninja_forms_display_pre_init', function () {

			// Construct array of fields and values
			$this->fields = $this->construct_fields( $this->get_options() );

			// Add fields to current form
			$this->add_fields( $this->fields );

		} );

		// When form submitted, add recon data
		add_action( 'ninja_forms_post_process', function () {

			// Get submission ID
			global $ninja_forms_processing;
			$this->sub_id = $ninja_forms_processing->get_form_setting( 'sub_id' );

			// Pull data out of post and store it as meta data
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
					$name = Helper::field_name( array( $category, $option ), $this->pretty_prefix );

					// Get value for field
					$value = Value::get( $option, $this->prefix );
					if ( !empty( $value ) ) $fields[ $name ] = $value;

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

		$fields = array();
		$length = strlen( $this->pretty_prefix );

		// Extract recon fields
		foreach ( $post as $key => $value ) {
			if ( substr( $key, 0, $length ) === $this->pretty_prefix ) {
				$fields[ $key ] = $value;
			}
		}

		// Convert to multi-array
		$fields = Helper::names_to_array( $fields );

		// Only push metas if they actually exist
		if ( !empty( $fields ) ) {

			// Move to flat vars to feed into closure
			$sub = $this->sub_id;
			$meta = $this->pretty_prefix . 'data';
			$value = json_encode( $fields['recon'] );

			/**
			 * Delay until `shutdown` so `Ninja_Forms()` definitely exists
			 *
			 * Tried `init`, `wp_loaded` and `wp` but still through error
			 * so went with thermonuclear solution
			 */
			add_action( 'shutdown', function () use ( $sub, $meta, $value ) {
				\Ninja_Forms()->sub( $sub )->update_meta( $meta, $value );
			}, 11 );

		}

	}

}
