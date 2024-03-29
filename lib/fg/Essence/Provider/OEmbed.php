<?php

/**
 *	@author Félix Girault <felix.girault@gmail.com>
 *	@license FreeBSD License (http://opensource.org/licenses/BSD-2-Clause)
 */

namespace fg\Essence\Provider;



/**
 *	Base class for an OEmbed provider.
 *	This kind of provider extracts embed informations through the OEmbed protocol.
 *
 *	@package fg.Essence.Provider
 */

abstract class OEmbed extends \fg\Essence\Provider {

	/**
	 *	JSON response format.
	 *
	 *	@var string
	 */

	const json = 'json';



	/**
	 *	XML response format.
	 *
	 *	@var string
	 */

	const xml = 'xml';

   const default_height = 444;

   const default_width = 592;



	/**
	 *	The expected response format.
	 *
	 *	@param string
	 */

	protected $_format = '';



	/**
	 *	The OEmbed endpoint.
	 *
	 *	@param string
	 */

	protected $_endpoint = '';



	/**
	 *	JSON error messages.
	 *
	 *	@var array
	 */

	protected $_jsonErrors = array(
		JSON_ERROR_NONE => 'no error',
		JSON_ERROR_DEPTH => 'depth error',
		JSON_ERROR_STATE_MISMATCH => 'state mismatch error',
		JSON_ERROR_CTRL_CHAR => 'control character error',
		JSON_ERROR_SYNTAX => 'syntax error',
		JSON_ERROR_UTF8 => 'UTF-8 error'
	);



	/**
	 *	Constructs the OEmbed provider with a regular expression to match the
	 *	URLs it can handle, and an OEmbed endpoint.
	 *
	 *	@param string $pattern A regular expression to match URLs.
	 *	@param string $endpoint The OEmbed endpoint URL.
	 *	@param string $format The expected response format.
	 */

	public function __construct( $pattern, $endpoint, $format ) {

		parent::__construct( $pattern );

		$this->_endpoint = $endpoint;
		$this->_format = $format;
	}



	/**
	 *	Strips arguments and anchors from the given URL.
	 *
	 *	@param string $url Url to prepare.
	 *	@return string Prepared url.
	 */

	protected function _prepare( $url ) {

		$url = parent::_prepare( $url );

		if ( !$this->_strip( $url, '?' )) {
			$this->_strip( $url, '#' );
		}

		return $url;
	}



	/**
	 *	Strips the end of a string after a delimiter.
	 *
	 *	@param string $string The string to strip.
	 *	@param string $delimiter The delimiter from which to strip the string.
	 *	@return boolean True if the string was modified, otherwise false.
	 */

	protected function _strip( &$string, $delimiter ) {

		$position = strpos( $string, $delimiter );

		if ( $position !== false ) {
			$string = substr( $string, 0, $position );
		}

		return ( $position !== false );
	}



	/**
	 *	Fetches embed information from the given URL.
	 *
	 *	@param string $url URL to fetch informations from.
	 *	@return Media Embed informations.
	 */

	protected function _embed( $url ) {

		$endpoint = sprintf( $this->_endpoint, urlencode( $url ));

		return $this->_embedEndpoint( $endpoint, $this->_format );
	}



	/**
	 *	Fetches embed information from the given endpoint.
	 *
	 *	@param string $endpoint Endpoint to fetch informations from.
	 *	@param string $format Response format.
	 *	@return Media Embed informations.
	 */

	protected function _embedEndpoint( $endpoint, $format ) {

		$response = \fg\Essence\Http::get( $this->_completeEndpoint( $endpoint ));

		switch ( $format ) {
			case self::json:
				$data = $this->_parseJson( $response );
				break;

			case self::xml:
				$data = $this->_parseXml( $response );
				break;

			default:
				throw new \fg\Essence\Exception( 'Unsupported format.' );
		}

		return new \fg\Essence\Media(
			$data,
			array(
				'author_name' => 'authorName',
				'author_url' => 'authorUrl',
				'provider_name' => 'providerName',
				'provider_url' => 'providerUrl',
				'cache_age' => 'cacheAge',
				'thumbnail_url' => 'thumbnailUrl',
				'thumbnail_width' => 'thumbnailWidth',
				'thumbnail_height' => 'thumbnailHeight',
			)
		);
	}



	/**
	 *	If some options were specified, append them to the endpoint URL.
	 *
	 *	@param string $endpoint Endpoint URL.
	 *	@return string Completed endpoint URL.
	 */

	protected function _completeEndpoint( $endpoint ) {

		if ( !empty( $this->_options )) {
			$params = array_intersect_key(
				$this->_options,
				array(
					'maxwidth' => '640',
					'maxheight' => '360'
				)
			);

			if ( !empty( $params )) {
				$endpoint .= ( strpos( $endpoint, '?' ) === false ) ? '?' : '&';
				$endpoint .= http_build_query( $params );
			}
		}

		return $endpoint;
	}



	/**
	 *	Parses a JSON response and returns an array of data.
	 *
	 *	@param string $json JSON document.
	 *	@return array Data.
	 */

	protected function _parseJson( $json ) {

		$data = json_decode( $json, true );

		if ( $data === null ) {
			throw new \fg\Essence\Exception(
				'Error parsing JSON response: '
				. $this->_jsonErrors[ json_last_error( )]
				. '.'
			);
		}

		return $data;
	}



	/**
	 *	Parses an XML response and returns an array of data.
	 *
	 *	@param string $xml XML document.
	 *	@return array Data.
	 */

	protected function _parseXml( $xml ) {

		libxml_use_internal_errors( true );

		$data = array( );
		$it = new \SimpleXmlIterator( $xml, null );

		foreach( $it as $key => $value ) {
			$data[ $key ] = strval( $value );
		}

		return $data;
	}
}
