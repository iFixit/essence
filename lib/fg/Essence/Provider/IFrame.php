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

abstract class IFrame extends \fg\Essence\Provider {

	/**
	 *	The expected response format.
	 *
	 *	@param string
	 */

	protected $_format = '';


   protected static $_type = 'rich';

	/**
    *
	 */

	public function __construct( $pattern ) {

		parent::__construct( $pattern );
	}



	/**
	 *	Strips arguments and anchors from the given URL.
	 *
	 *	@param string $url Url to prepare.
	 *	@return string Prepared url.
	 */

	protected function _prepare( $url ) {

	   return parent::_prepare( $url );
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
	 *	Parses some iFrame html and returns an array of data.
	 *
	 *	@param string $html 
	 *	@return array Data.
	 */

	protected function _parseIframe( $html ) {
      var_dump( $html );

		return $data;
	}
}
