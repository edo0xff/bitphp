<?php namespace BitPHP;
  
  /**
  *	Static class that provides methods for data entry validation
  *
  *	<p>This class can be used independently of BitPHP, but you could use the
  *	<b>url_param()</b> method as it works with variables created by BitPHP.</p>
  *	<p>This class will facilitate the task of validating the various parameters
  *	reciven by forms, by the url, or cookies, still in development.</p>
  *
  *	@author Eduardo B <ms7rbeta@gmail.com>
  *	@version beta 1.3.0
  * @package Core
  *	@since bitphp 2.0
  *	@link bitphp.root404.com/docs/html/classes/Input.html you can see docs of Input if you work without BitPHP here
  *	@copyright 2014 Root404 Co.
  *	@website http://bitphp.root404.com <contacto@root404.com>
  *	@license GNU/GPLv3
  */
  class Input {

    /**
    *	Gets the value of the specified index in the specified method.
    *	if method is null, returns $key
    *
    *	@param string $m method to work (GET, POST, COOKIE, (and URLPARAMS in bitphp))
    *	@param string $k index of ($_POST, $_GET or $_COOKIE) to search
    *	@return string
    */
    protected static function get_value($m, $k, $f = true) 
    {
      switch(strtoupper($m)) {
        case 'POST':
          $s = self::post($k, $f);
          break;
        case 'GET':
          $s = self::get($k, $f);
          break;
        case 'COOKIE':
          $s = self::cookie($k, $f);
          break;
        case 'URL_PARAM':
          $s = self::url_param($k, $f);
          break;
        case null:
          $s = $k;
          break;
      }

      return $s;
    }

    /**
    *	if you use this class alone, you can download bitphp here -> bitphp.root404.com
    *
    *	<p>ONLY WITH BITPHP, gets the value of the specified index in url params, and filters
    *	html chars, return null if index isn't set.</p><p>Url parameters are received here more
    *	easily, however, you can do as in previous versions, for compatibility with applications
    *	developed in previous versions.</p>
    *
    *	@global string $_URLPARAMS this variable contains url parameters
    *	@param string $i index of $_params to search
    *	@param boolean $html_filter optional param, indicates whether to filter html chars, true by default
    *	@return string
    *	@example /var/www/docs/examples/Input_url_param_ex.php
    *	@todo was changed htmlspecialchars () by htmlentities () because it is faster
    */
    public static function url_param($i, $html_filter = true)
    {
      global $_URL;

      if( is_numeric($i) ) { 
        $i += ( Config::DEV || Config::ENABLE_PRO_MULTI_APP ) ? 3 : 2 ;
        $s = !empty($_URL[$i]) ? $_URL[$i] : null;
      } else {
        $i = array_search($i, $_URL);
        $s = ($i !== false) ? $_URL[$i + 1] : null ;
      }
    
      return $html_filter ? htmlentities($s, ENT_QUOTES) : $s;
    }

    /**
    *	Gets the value of the specified key in $_POST, and filters
    *	html chars, return null if key isn't set.
    *
    *	@param string $k index of $_POST to search
    *	@param boolean $html_filter optional param, indicates whether to filter html chars, true by default
    *	@return string
    *	@example /var/www/docs/examples/Input_post_ex.php
    *	@todo was changed htmlspecialchars () by htmlentities () because it is faster
    */
    public static function post($k, $html_filter = true)
    {
      $s = !empty($_POST[$k]) ? $_POST[$k] : null;
      return $html_filter ? htmlentities($s, ENT_QUOTES) : $s;
    }

    /**
    *	Gets the value of the specified key in $_GET, and filters
    *	html chars, return null if key isn't set.
    *
    *	@param string $k index of $_GET to search
    *	@param boolean $html_filter optional param, indicates whether to filter html chars, true by default
    *	@return string
    *	@example /var/www/docs/examples/Input_get_ex.php
    *	@todo was changed htmlspecialchars () by htmlentities () because it is faster
    */
    public static function get($k, $html_filter = true)
    {
      $s = !empty($_GET[$k]) ? $_GET[$k] : null;
      return $html_filter ? htmlentities($s, ENT_QUOTES) : $s;
    }

    /**
    *	Gets the value of the specified key in $_COOKIE, and filters
    *	html chars, return null if key isn't set.
    *
    *	@param string $k index of $_COOKIE to search
    *	@param boolean $html_filter optional param, indicates whether to filter html chars, true by default
    *	@return string
    *	@example /var/www/docs/examples/Input_cookie_ex.php
    *	@todo was changed htmlspecialchars () by htmlentities () because it is faster
    */
    public static function cookie($k, $html_filter = true)
    {
      $s = !empty($_COOKIE[$k]) ? $_COOKIE[$k] : null;
      return $html_filter ? htmlentities($s, ENT_QUOTES) : $s;
    }
  }
?>