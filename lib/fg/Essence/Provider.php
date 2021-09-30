<?php

/**
 *	@author Félix Girault <felix.girault@gmail.com>
 *	@license FreeBSD License (http://opensource.org/licenses/BSD-2-Clause)
 */

namespace fg\Essence;



/**
 *	Base class for a Provider.
 *
 *	@package fg.Essence
 */

abstract class Provider {

	/**
	 *	A regular expression that doesn't match anything.
	 *
	 *	@var string
	 */

	const nothing = '#(?=a)b#';



	/**
	 *	A regular expression that matches anything.
	 *
	 *	@var string
	 */

	const anything = '#.*#';



	/**
	 *	A regular expression used to determine if an URL can be handled by the
	 *	provider.
	 *
	 *	@var string
	 */

	protected $_pattern = '';



	/**
	 *	Options passed to embed( ) and to be used by _prepare( ) and _embed( ).
	 *
	 *	@var array
	 */

	protected $_options = array( );



	/**
	 *	Constructs the Provider with a regular expression to match the URLs
	 *	it can handle.
	 *
	 *	@param string $pattern The regular expression.
	 */

	public function __construct( $pattern = Provider::nothing ) {

		$this->_pattern = $pattern;
	}



	/**
	 *	Tells if the provider can fetch embed informations from the given URL.
	 *
	 *	@param string $url URL to fetch informations from.
	 */

	public function canEmbed( $url ) {
		return ( boolean ) preg_match( $this->_pattern, $url );
	}



	/**
	 *	Fetches embed information from the given URL.
	 *
	 *	@param string $url URL to fetch informations from.
	 *	@param array $options Custom options to be interpreted by the provider.
	 *	@return Media|null Embed informations, or null if nothing
	 *		could be fetched.
	 */

	public final function embed( $url, array $options = array( )) {

		$this->_options = $options;

		$url = $this->_prepare( $url );
		$Media = $this->_embed( $url );

		if ( empty( $Media->url )) {
			$Media->url = $url;
		}

		return $Media;
	}



	/**
	 *	Prepares an URL before fetching its contents. This method can be
	 *	overloaded in subclasses to do some preprocessing.
	 *
	 *	@param string $url URL to prepare.
	 *	@return string Prepared URL.
	 */

	protected function _prepare( $url ) {

		return trim( $url );
	}



	/**
	 *	Does the actual fetching of informations.
	 *
	 *	@param string $url URL to fetch informations from.
	 *	@return Media Embed informations.
	 *	@throws \fg\Essence\Exception
	 */

	abstract protected function _embed( $url );

}
