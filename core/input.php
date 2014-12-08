<?php
  namespace BitPHP;
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
  *	@package BitPHPCore
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
    private static function get_value($m, $k) {
      switch(strtoupper($m)) {
	case 'POST':
	  $s = self::post($k);
	  break;
	case 'GET':
	  $s = self::get($k);
	  break;
	case 'COOKIE':
	  $s = self::cookie($k);
	  break;
	case 'URL_PARAM':
	  $s = self::url_param($k);
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
      global $_URLPARAMS;
      $i += 2;
      $s = !empty($_URLPARAMS[$i]) ? $_URLPARAMS[$i] : null;
      return $html_filter ? htmlentities(stripslashes($s), ENT_QUOTES) : $s;
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
      return $html_filter ? htmlentities(stripslashes($s), ENT_QUOTES) : $s;
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
      return $html_filter ? htmlentities(stripslashes($s), ENT_QUOTES) : $s;
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
      return $html_filter ? htmlentities(stripslashes($s), ENT_QUOTES) : $s;
    }

    /**
    *	Gets value of index in specified method, and validate it a password,
    *	to be acceptable password must contain at least 8 characters,
    *	including: uppercase, lowercase and numbers
    *
    *	@param string $m method to search (POST, GET, COOKIE, (and URLPARAMS in bitphp))
    *	@param mixed $k keys to search in the method
    *	@param boolean $cryp indicates whether the return value is to be encrypted
    *	@param string $hash indicates the encryption algorithm using
    *	@return string
    *	@example /var/www/docs/examples/Input_pass_ex.php
    */
    public static function pass($m, $k, $cryp = true, $hash = 'sha256')
    {
      $s1 = self::get_value($m, $k[0]);
      $s2 = self::get_value($m, $k[1]);

      if($s1 != $s2){ return null; }

      $match = preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $s1);
      if(!$match){ return null; }

      return $cryp ? hash($hash, $s1) : $s1;
    }

    /**
    *	Gets value of index in specified method, and validate it a email.
    *
    *	@param string $m method to search (POST, GET, COOKIE, (and URLPARAMS in bitphp))
    *	@param string $k key to search in the method
    *	@return string
    *	@example /var/www/docs/examples/Input_email_ex.php
    */
    public static function email($m, $k)
    {
      $s = self::get_value($m, $k);

      if(!$s){ return null; }

      $match = preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/',$s);
      return $match ? $s : null;
    }

    /**
    *	Gets value of index in specified method, and validate it a number,
    *	and converts to integer or float if so indicated
    *
    *	@param string $m method to search (POST, GET, COOKIE, (and URLPARAMS in bitphp))
    *	@param string $k key to search in the method
    *	@param string $t if indicated, converts the data type (INT or FLOAT)
    *	@return mixed
    *	@example /var/www/docs/examples/Input_number_ex.php
    */
    public static function number($m, $k, $t = null)
    {
      $s = self::get_value($m, $k);

      if(!$s){ return false; }

      if(is_numeric($s)) {
	switch(strtoupper($t)) {
	  case 'INT':
	    return intval($s);
	  case 'FLOAT':
	    return floatval($s);
	  case null:
	    return $s;
	}
      } else {
	return false;
      }
    }

    /**
    *	Gets a value of index specified method, and valid length.
    *
    *	@param string $m method to search (POST, GET, COOKIE, (and URLPARAMS in bitphp))
    *	@param string $k key to search in the method
    *	@param integer $max_len maximum number of characters allowed
    *	@param integer $min_len minimum number of characters allowed
    *	@return string
    *	@example /var/www/docs/examples/Input_large_as_ex.php
    */
    public static function large_as($m, $k, $max_len = 1024, $min_len = 1)
    {
      $s = self::get_value($m, $k);

      if(!$s){ return null; }

      $s = strlen($s) < $max_len ? $s : null;
      if(!$s){ return null; }

      $s = strlen($s) >= $min_len ? $s : null;
      if(!$s){ return null; }

      return $s;
    }

    /**
    *	Gets a pre-formated-text, eg. from any textarea, scape '\n' to '&#60;br&#62;'
    *
    *	also use this function to get supported strings with <b>json_encode()</b>
    *
    *	@param string $m method to search (POST, GET, COOKIE, (and URLPARAMS in bitphp))
    *	@param string $k key to search in the method
    *	@return string
    *	@example /var/www/docs/examples/Input_pre.php
    */
    public static function pre($m, $k) {
      $s = self::get_value($m, $k);

      if(!$s){ return null; }

      $s = str_replace("\n", "<br>", $s);
      return $s;
    }

  }

?>