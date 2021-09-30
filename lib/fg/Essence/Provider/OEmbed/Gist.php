<?php

/**
 *	@author Félix Girault <felix.girault@gmail.com>
 *	@license FreeBSD License (http://opensource.org/licenses/BSD-2-Clause)
 */

namespace fg\Essence\Provider\OEmbed;



/**
 *	Github Gist provider (https://gist.github.com).
 *
 *	@package fg.Essence.Provider.OEmbed
 */

class Gist extends \fg\Essence\Provider\OEmbed {

   protected static $_css = 'https://gist.github.com/stylesheets/gist/embed.css';

	/**
	 *	Constructor.
	 */

	public function __construct( ) {

      // Example: https://gist.github.com/kwiens/fa938b4853752b66d0f7
		parent::__construct(
			'/^https?:\/\/(?:www\.)?gist\.github\.com\/\w.*\/(.*)$/',
			'https://gist.github.com/%s.json',
			self::json
		);
	}

   public function _prepare( $url ) {
      $url = parent::_prepare( $url );

      // If the url already is .json, remove it to normalize the URLs
      if (preg_match('#.json#', $url)) {
         $url = preg_replace('#.json#', '', $url);
      }

      return $url;
   }

   public function _embed( $url ) {
      if (!preg_match('#.json#', $url)) 
         $url .= '.json';

      $data = parent::_embedEndpoint( $url, 'json' );
      $data->provider_url = 'https://github.com';
      $data->provider_name = 'Github';
      $data->author_name = $data->owner;
      $data->author_url = $data->provider_url . '/' . $data->owner;
      $data->width = self::default_width;
      $data->height = self::default_height;
      $data->html = '' . $data->div;

      return $data;
   }
}
