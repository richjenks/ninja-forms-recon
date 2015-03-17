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

		global $ninja_forms_loading;

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
			case 'Date + Time':
				return date( 'r' );
				break;
			case 'Timestamp':
				return time();
				break;

			// User
			case 'User ID':
				return $ninja_forms_loading->data['user_ID'];
				break;
			case 'User Name':
				$user = get_userdata( $ninja_forms_loading->data['user_ID'] );
				return $user->data->user_nicename;
				break;
			case 'User Email':
				$user = get_userdata( $ninja_forms_loading->data['user_ID'] );
				return $user->data->user_email;
				break;
			case 'User Role':
				$user = get_userdata( $ninja_forms_loading->data['user_ID'] );
				return $user->roles[0];
				break;
			case 'User Agent':
				if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ); return $_SERVER['HTTP_USER_AGENT'];
				break;
			case 'IP Address':
				if ( isset( $_SERVER['REMOTE_ADDR'] ) ); return $_SERVER['REMOTE_ADDR'];
				break;
			case 'Operating System':
				return self::user_agent( 'platform_name', $prefix );
				break;
			case 'Browser':
				return self::user_agent( 'browser_name', $prefix ) . ' ' . self::user_agent( 'browser_version', $prefix );
				break;

			// Google Campaign
			case 'utm_source':
				if ( isset( $_GET['utm_source'] ) )  return $_GET['utm_source'];
				if ( isset( $_GET['_utmsource'] ) )  return $_GET['_utmsource'];
				break;
			case 'utm_medium':
				if ( isset( $_GET['utm_medium'] ) )  return $_GET['utm_medium'];
				if ( isset( $_GET['_utmmedium'] ) )  return $_GET['_utmmedium'];
				break;
			case 'utm_term':
				if ( isset( $_GET['utm_term'] )  )   return $_GET['utm_term'];
				if ( isset( $_GET['_utmterm'] )  )   return $_GET['_utmterm'];
				break;
			case 'utm_content':
				if ( isset( $_GET['utm_content'] ) ) return $_GET['utm_content'];
				if ( isset( $_GET['_utmcontent'] ) ) return $_GET['_utmcontent'];
				break;
			case 'utm_name':
				if ( isset( $_GET['utm_name'] )  )   return $_GET['utm_name'];
				if ( isset( $_GET['_utmname'] )  )   return $_GET['_utmname'];
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

	/**
	 * user_agent
	 *
	 * @param string $var    Info to get
	 * @param string $prefix Plugin "namespace" prefix
	 *
	 * @return string|array Specific or all user agent info
	 */

	public static function user_agent( $var = false, $prefix = '' ) {

		// If ua data not known, get it
		if ( !isset( $_SESSION[ $prefix . 'user_agent' ] ) ) {
			$api_key = '5874e73c';
			$user_agent = urlencode( $_SERVER['HTTP_USER_AGENT'] );
			$json = @file_get_contents( "http://useragentapi.com/api/v2/json/$api_key/$user_agent" );
			$_SESSION[ $prefix . 'user_agent' ] = json_decode( $json, true );
		}

		// Handle API failing
		if ( !is_array( $_SESSION[ $prefix . 'user_agent' ] ) ) return false;

		// Return either all data or specific item
		return ( $var ) ? $_SESSION[ $prefix . 'user_agent' ][ $var ] : $_SESSION[ $prefix . 'user_agent' ];

	}

}