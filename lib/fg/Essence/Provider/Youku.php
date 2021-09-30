<?php

namespace fg\Essence\Provider;

class Youku extends \fg\Essence\Provider\IFrame {

   protected static $urlRegex = '#^https?://(?:v\.)?youku\.com/v_show/id_([A-Za-z0-9]+)==\.html#';

   public function __construct( ) {
      parent::__construct(self::$urlRegex);
   }

   public function _embed($url) {
      $embedUrl = $this->parseUrl($url);
      $info = [
         'provider_url' => 'https://www.youku.com',
         'provider_name' => 'Youku',
         'author_name' => 'Youku',
         'author_url' => $url,
         'url' => encode($embedUrl),
      ];
      $data = new \fg\Essence\Media($info);
      return $data;
   }

   // This will only work if the document is set to web publish
   private function parseUrl($url) {
      if (!preg_match(self::$urlRegex, $url, $matches)) {
         return '';
      }
      $id = $matches[1];
      $url = "https://player.youku.com/embed/$id";

      return $url;
   }

}
