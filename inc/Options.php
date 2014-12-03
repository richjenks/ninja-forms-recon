<?php

/**
 * Options
 *
 * Interface for options storage
 */

namespace RichJenks\NFRecon;

class Options extends Plugin {

	/**
	 * options
	 *
	 * Structure: `$options[ $category ][ $field ]`
	 *
	 * @var array Cached options, so not hitting database every time
	 */

	protected $options;

	/**
	 * get_options
	 *
	 * Only allows fields that are in defaults but stored values will override defaults
	 * Fields can be deprecated by removing from defaults
	 * Hits database twice on first run but caches options for later retrieval
	 *
	 * @return array Plugin options
	 */

	protected function get_options() {

		// Construct default options
		$defaults = array(

			'Content' => array(
				'Current URL'  => false,
				'Previous URL' => false,
				'Post Title'   => false,
				'Form Name'    => false,
			),

			'User' => array(
				'User Agent'       => false,
				'IP Address'       => false,
				'Operating System' => false,
				'Browser'          => false,
				'Browser Version'  => false,
			),

			'Google Campaign' => array(
				'utm_source'  =>  false,
				'utm_medium'  =>  false,
				'utm_term'    =>  false,
				'utm_content' =>  false,
				'utm_name'    =>  false,
			),

			'Geolocation' => array(
				'City'         => false,
				'Country'      => false,
				'Country Code' => false,
				'ISP'          => false,
				'Latitude'     => false,
				'Longitude'    => false,
				'Organisation' => false,
				'Region'       => false,
				'Region Name'  => false,
				'Timezone'     => false,
				'Zip'          => false,
			),

		);

		// Get current options as array
		$options = json_decode( get_option( $this->prefix . 'options', '[]' ), true );

		// Merge options
		$options = array_replace_recursive( $defaults, $options );

		// Remove options not in defaults (deprecated options)
		foreach ( $options as $category => $fields ) {
			foreach ($fields as $field => $value) {
				if ( !isset( $defaults[ $category ][ $field ] ) ) {
					unset( $options[ $category ][ $field ] );
				}
			}
		}

		// Send options back to database so don't need to save to deprecate options
		// Otherwide, fields would continue to show in forms until options were saved
		$this->set_options( $options );

		// Cache options before returning
		$this->options = $options;
		return $this->options;

	}

	/**
	 * set_options
	 *
	 * Puts options in storage
	 *
	 * @param array $options Plugin options
	 */

	protected function set_options( $options ) {
		update_option( $this->prefix . 'options', json_encode( $options ) );
	}

	/**
	 * integrate_options
	 *
	 * $options is a multidimensional array like `$options[ $category ][ $field ]`
	 * When provided with some options from one category
	 * this function will integrate them and return the full set of options
	 *
	 * Assumes set value is true and unset is false — because checkboxes are weird.
	 *
	 * @param array $post $_POST array
	 * @param string $category Index of
	 */

	protected function integrate_options( $options = false ) {

		// Get options category
		$category = key( $options );

		// Change values to bools
		foreach ( $options[ $category ] as $option => $value ) {
			$options[ $category ][ $option ] = (bool) $value;
		}

		// Return merged options
		return array_merge( $this->get_options(), $options );

	}

}