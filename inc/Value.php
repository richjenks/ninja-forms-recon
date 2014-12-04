<?php

/**
 * Value
 *
 * Used to get the value for a given piece of info
 */

namespace RichJenks\NFRecon;

class Value {

	/**
	 * get
	 *
	 * Calculates and returns the value for the requested variable
	 *
	 * @param string $var    Name of the variable to get value for
	 * @param string $prefix Plugin "namespace" prefix
	 *
	 * @return string Requested value
	 */

	public static function get( $var, $prefix ) {
		switch ( $var ) {

			// Content
			case 'Current URL':
				$s = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ) ? 's' : '';
				$url = 'http' . $s . '://';
				$url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
				return $url;
				break;
			case 'Previous URL':
				if ( isset( $_SERVER['HTTP_REFERER'] ) ) return $_SERVER['HTTP_REFERER'];
				break;
			case 'Refering URL':
				if ( isset( $_SESSION['original_referer'] ) ) return $_SESSION['original_referer'];
				break;
			case 'Post Title':
				return get_the_title();
				break;
			case 'Post ID':
				return get_the_id();
				break;
			case 'Form Title':
				return $ninja_forms_loading->data['form']['form_title'];
				break;
			case 'Form ID':
				return $ninja_forms_loading->data['form_ID'];
				break;

			// User
			case 'User Agent':
				if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ); return $_SERVER['HTTP_USER_AGENT'];
				break;
			case 'IP Address':
				if ( isset( $_SERVER['REMOTE_ADDR'] ) ); return $_SERVER['REMOTE_ADDR'];
				break;
			case 'Operating System':
				return 'Linux';
				break;
			case 'Browser':
				return 'Chrome';
				break;
			case 'Browser Version':
				return '39';
				break;

			// Google Campaign
			case 'utm_source':
				if ( isset( $_GET['utm_source'] ) )  return $_GET['utm_source'];
				break;
			case 'utm_medium':
				if ( isset( $_GET['utm_medium'] ) )  return $_GET['utm_medium'];
				break;
			case 'utm_term':
				if ( isset( $_GET['utm_term'] )  )   return $_GET['utm_term'];
				break;
			case 'utm_content':
				if ( isset( $_GET['utm_content'] ) ) return $_GET['utm_content'];
				break;
			case 'utm_name':
				if ( isset( $_GET['utm_name'] )  )   return $_GET['utm_name'];
				break;

			// Geolocation
			case 'City':
				return self::geolocation( 'city', $prefix );
				break;
			case 'Country':
				return self::geolocation( 'country', $prefix );
				break;
			case 'Country Code':
				return self::geolocation( 'countryCode', $prefix );
				break;
			case 'ISP':
				return self::geolocation( 'isp', $prefix );
				break;
			case 'Latitude':
				return self::geolocation( 'lat', $prefix );
				break;
			case 'Longitude':
				return self::geolocation( 'lon', $prefix );
				break;
			case 'Organisation':
				return self::geolocation( 'org', $prefix );
				break;
			case 'Region':
				return self::geolocation( 'region', $prefix );
				break;
			case 'Region Name':
				return self::geolocation( 'regionName', $prefix );
				break;
			case 'Timezone':
				return self::geolocation( 'timezone', $prefix );
				break;
			case 'Zip':
				return self::geolocation( 'zip', $prefix );
				break;

		}

	}

	/**
	 * geolocation
	 *
	 * @param string $var    Info to get
	 * @param string $prefix Plugin "namespace" prefix
	 *
	 * @return string|array Specific or all geolocation info
	 */

	public static function geolocation( $var = false, $prefix = '' ) {

		// If geo data not known, get it
		if ( !isset( $_SESSION[ $prefix . 'geolocation' ] ) ) {
			$json = @file_get_contents( 'http://ip-api.com/json/' . $_SERVER['REMOTE_ADDR'] );
			$_SESSION[ $prefix . 'geolocation' ] = json_decode( $json, true );
		}

		// Handle API failing
		if ( $_SESSION[ $prefix . 'geolocation' ]['status'] === 'fail' ) return false;

		// Return either all data or specific item
		return ( $var ) ? $_SESSION[ $prefix . 'geolocation' ][ $var ] : $_SESSION[ $prefix . 'geolocation' ];

	}

}