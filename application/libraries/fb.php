<?php

class Fb {
   
   private $appid = '';
   private $secret = '';
   private $scope = '';
   private $sdk = null;

   public function __construct()
   {
      $ci =& get_instance();
      $ci->config->load('fb');
      $this->appid = $ci->config->item('fb_appid');
      $this->secret = $ci->config->item('fb_secret');
      $this->scope = $ci->config->item('fb_scope');

      //load the library
      $this->load();
   }

   private function load()
   {
      require_once 'facebook-php-sdk/src/facebook.php';

      $credentials = array(
         'appId' => $this->appid,
         'secret' => $this->secret,
         'cookie' => true
      );

      $this->sdk = new Facebook($credentials);
   }

   function is_logged_in()
   {
      $user = $this->sdk->getUser();
      if ($user)
         return true;

      return false;
   }

   function get_auth_url($uri)
   {
      $params = array(
         'redirect_uri' => $uri,
         'scope' => $this->scope
      );

      if ($this->is_logged_in())
         return $this->sdk->getLogoutUrl($params);

      return $this->sdk->getLoginUrl($params);
   }

   function run_fql_query($query)
   {
      return $this->sdk->api(array(
         'method' => 'fql.query',
         'query' => $query
      ));
   }

}