<?php

/**
 *	@author Timothy Asp
 *	@license FreeBSD License (http://opensource.org/licenses/BSD-2-Clause)
 */

namespace fg\Essence\Provider;



/**
 *	AutoDesk Publisher provider (http://360.autodesk.com).
 *
 *	@package fg.Essence.Provider.IFrame
 */

class AutoDeskPublisher extends \fg\Essence\Provider\IFrame {

   protected static $_baseUrl = "https://360.autodesk.com";
   protected static $_baseName = "AutoDesk";

	/**
	 *	Constructor.
	 */

	public function __construct( ) {

		parent::__construct(
         '#autodesk.com#i'
		);
	}

   public function _embed( $url ) {
      $data = array();
      $data['html'] = $url;
      $data['type'] = self::$_type;
      $data['provider_url'] = self::$_baseUrl;
      $data['provider_name'] = self::$_baseName;
      $data['url'] = $url;
      $data['width'] = 592;
      $data['height'] = 555;
      $data['title'] = "Auto desk publisher embed";

		return new \fg\Essence\Media(
			$data,
         array(
            'src' => 'url'
         )
      );
   }

   public function _splitQueryArgs($url) {
      return explode('?file=', urldecode($url));
   }
}
