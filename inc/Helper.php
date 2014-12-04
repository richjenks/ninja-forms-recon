<?php

/**
 * Helper
 *
 * Class of static helper functions
 */

namespace RichJenks\NFRecon;

class Helper {

	/**
	 * field_name
	 *
	 * Turns a heirarchy of parents into one canonical name
	 * Separates parts with underscores, replaces spaces with hyphens
	 * and adds an optional prefix
	 *
	 * @param array  $parts Each part of the name
	 * @param string $prefix Prefix for element name
	 *
	 * @return string Full name
	 */

	public static function field_name( $parts, $prefix = '' ) {
		foreach ( $parts as $key => $part )
			$parts[ $key ] = str_replace( ' ', '-', $part );
		$parts = implode( '_', $parts );
		return $prefix . $parts;
	}

	/**
	 * names_to_array
	 *
	 * Turns a collection of flattened names into an associative, multidimentional array
	 *
	 * @param  array $names Full field names
	 * @return array Multidimentional array of data from names
	 */

	public static function names_to_array( $names ) {

		$data = array();

		foreach ( $names as $name => $value ) {

			// Split into heirarchy
			$parts = explode( '_', $name );

			// Swap hyphens for spaces
			foreach ( $parts as $part_key => $part_value ) {
				$parts[ $part_key ] = str_replace( '-', ' ', $part_value );
			}

			// Add to data
			$data[ $parts[0] ][ $parts[1] ][ $parts[2] ] = $value;

		}

		return $data;
	}

}