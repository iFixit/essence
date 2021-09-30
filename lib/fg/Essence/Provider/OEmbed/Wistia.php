<?php

/**
 * @author Andrew Pirondini <andrewp@ifixit.com>
 * @license FreeBSD License (http://opensource.org/license/BSD-2-Clause)
 */

namespace fg\Essence\Provider\OEmbed;



/**
 * Wistia provider (http://www.wistia.com).
 *
 * @package fg.Essence.Provider.OEmbed
 */

class Wistia extends \fg\Essence\Provider\OEmbed {

   /**
    *	Constructor.
    */
   
   public function __construct() {
      parent::__construct(
       '#https?://(.+)?(wistia\.com|wi\.st)/(medias|embed)/#i',
       'http://fast.wistia.com/oembed?url=%s',
       self::json
      );
   }

   /**
    * Function for refactoring urls as needed for embed. Nothing
    * other than the default trim behavior is required here.
    *
    * @param string $url URL to refactor.
    * @return string Refactored URL.
    */

   protected function _prepare($url) {
      return \fg\Essence\Provider::_prepare($url);  
   }
}
