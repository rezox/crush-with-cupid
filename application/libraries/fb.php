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

      require_once 'facebook-php-sdk/src/facebook.php';

      $credentials = array(
         'appId' => $this->appid,
         'secret' => $this->secret,
         'cookie' => true
      );

      $this->sdk = new Facebook($credentials);
   }

   function clear_session()
   {
      $this->sdk->destroySession();

      // // get your api key 
      // $apiKey = $this->sdk->getAppId();
      // // get name of the cookie 
      // $cookie = $this->sdk->getSignedRequestCookieName();

      // $cookies = array('user', 'session_key', 'expires', 'ss'); 
      // foreach ($cookies as $name)  
      // { 
      //    setcookie($apiKey . '_' . $name, false, time() - 3600); 
      //    unset($_COOKIE[$apiKey . '_' . $name]); 
      // } 

      // setcookie($apiKey, false, time() - 3600); 
      // unset($_COOKIE[$apiKey]);      
   }

   function get_user()
   {
      $query = 'SELECT uid, name, sex, email, pic_square FROM user WHERE uid = me()';
      $response = $this->run_fql_query($query);

      return $response[0];
   }

   function is_logged_in()
   {
      // die($this->sdk->getUser());
      $user = $this->sdk->getUser();
      // $user = $this->get_access_token();
      if ($user)
         return true;

      return false;
   }

   function get_auth_url($uri)
   {
      if ($this->is_logged_in())
         return $this->sdk->getLogoutUrl(array('next' => $uri));

      return $this->sdk->getLoginUrl(array(
         'scope' => $this->scope,
         'redirect_uri' => $uri,
      ));
   }

   function run_fql_query($query)
   {
      return $this->sdk->api(array(
         'method' => 'fql.query',
         'query' => $query
      ));
   }

   function get_access_token()
   {
      return $this->sdk->getAccessToken();
   }

   function get_app_id()
   {
      return $this->appid;
   }

}