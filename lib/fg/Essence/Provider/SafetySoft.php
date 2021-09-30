<?php

namespace fg\Essence\Provider;

class SafetySoft extends \fg\Essence\Provider\IFrame {

   protected static $urlRegex = '#^https?://(?:wave\.)?safetysoft\.com/share/([\w-]+)\?embed=1$#i';

   public function __construct() {
      parent::__construct(self::$urlRegex);
   }

   public function _embed($url) {
      $encodedUrl = encode($url);

      $info = [
         'provider_url' => 'https://wave.safetysoft.com',
         'provider_name' => 'SafetySoft',
         'author_name' => 'SafetySoft',
         'url' => $url,
         'html' => "<iframe src=\"{$encodedUrl}\" allowfullscreen></iframe>",
      ];
      $data = new \fg\Essence\Media($info);

      return $data;
   }
}
