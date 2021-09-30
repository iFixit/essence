<?php

/**
 *	@author Timothy Asp
 *	@license FreeBSD License (http://opensource.org/licenses/BSD-2-Clause)
 */

namespace fg\Essence\Provider;



/**
 *	Upverter provider (http://upverter.com).
 *
 *	@package fg.Essence.Provider.IFrame
 */

class Upverter extends \fg\Essence\Provider\IFrame {

	/**
	 *	Constructor.
	 */

	public function __construct( ) {

		parent::__construct(
			'#upverter\.com#s',
         'http://upverter.com/.+[^\'"]'
		);
	}


	/**
	 *	Fetches embed information from the given URL.
	 *
	 *	@param string $url URL to fetch informations from.
	 *	@return Media Embed informations.
	 */

	protected function _embed( $url ) {

      // URL is actually the iFrame html
      var_dump($url);

      $attrs = \fg\Essence\Html::extractAttributes($url, array(
         'iframe' => array(
            'title', 'width', 'height', 'name', 'src', 
         )
      ));

      $attrs = $attrs['iframe'][0];
      $attrs['html'] = $url;
      $attrs['url'] = $attrs['src'];
      unset($attrs['src']);
      $attrs['type'] = self::$_type;

		return new \fg\Essence\Media( $attrs );

	}

}
