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
	 * @param string $label User-friendly label
	 * @param string $prefix Prefix for element names
	 *
	 * @return string Form element name
	 */

	public static function field_name( $label, $prefix = '' ) {
		return str_replace( ' ', '_', strtolower( $prefix . $label ) );
	}

}