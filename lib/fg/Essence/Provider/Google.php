<?php

namespace fg\Essence\Provider;

/**
 *	Google Maps + Docs provider
 *
 *	@package fg.Essence.Provider.OEmbed
 * @author KW
 */

class Google extends \fg\Essence\Provider\IFrame {

   protected static $docRegex = '/^https?:\/\/docs\.google\.com\/(document|spreadsheets|presentation)\/d\/([a-zA-Z0-9_-]+)\/[edit|pubhtml].+/';

   public function __construct( ) {
      // Example: https://docs.google.com/spreadsheets/d/1Q-j8PPGrxk1GU5Tn56G6nQpMmcuaCGgDs_d9uhdxT-k/pubhtml?gid=0&amp;single=true&amp;widget=true&amp;headers=false
      parent::__construct(self::$docRegex);
   }

   public function _prepare( $url ) {
      $url = parent::_prepare( $url );

      return $url;
   }

   // Construct url from google docid
   // This will only work if the document is set to web publish
   private function parseDocURL($url) {
      if (!preg_match(self::$docRegex, $url, $matches)) {
         return '';
      }
      $doctype = $matches[1];
      $docid = $matches[2];

      // Picking sane defaults for simple view.
      // single=true: just display a single sheet
      // gid=0: First sheet of document
      if ($doctype == 'spreadsheets') {
         $arguments = '/pubhtml?gid=0&single=true&widget=true&headers=false';
      } else if ($doctype == 'document') {
         $arguments = '/pub?embedded=true';
      } else if ($doctype == 'presentation') {
         $arguments = '/embed?start=false&loop=false&delayms=3000';
      } else {
         $arguments = '';
      }

      $url = "https://docs.google.com/$doctype/d/$docid{$arguments}";

      return $url;
   }

   public function _embed( $url ) {
      $data = new \fg\Essence\Media([]);
      $data->provider_url = 'https://docs.google.com';

      $data->provider_name = 'Google';
      $data->author_name = 'Google';
      $data->author_url = $url;
      $data->url = encode(self::parseDocURL($url));
      $data->html = "<iframe src=\"$url\"></iframe>";
      return $data;
   }
}
