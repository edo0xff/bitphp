<?php use \BitPHP\Mvc\Input;

  /**
  * @author Eduardo B <ms7rbeta@gmail.com>
  */
	class InputValidate extends Input {

  /**
    * Gets the value of the specified index in the specified method.
    * if method is null, returns $key
    *
    * @param string $m method to work (GET, POST, COOKIE, (and URLPARAMS in bitphp))
    * @param string $k index of ($_POST, $_GET or $_COOKIE) to search
    * @return string
    */
    protected static function getValue($m, $k, $f = true) 
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
          $s = self::getUrlValue($k, $f);
          break;
        case null:
          $s = $k;
          break;
      }

      return $s;
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
    */
    public static function pass($m, $k, $cryp = true, $hash = 'sha256')
    {
      $s1 = self::getValue($m, $k[0]);
      $s2 = self::getValue($m, $k[1]);

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
    */
    public static function email($m, $k)
    {
      $s = self::getValue($m, $k);

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
    */
    public static function number($m, $k, $t = null)
    {
      $s = self::getValue($m, $k);
      if( $s === null ){ return false; }

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
    */
    public static function large_as($m, $k, $max_len = 1024, $min_len = 1)
    {
      $s = self::getValue($m, $k);

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
    */
    public static function pre($m, $k, $f = true) {
      $s = self::getValue($m, $k, $f);

      if(!$s){ return null; }

      $s = str_replace("\n", "<br>", $s);
      return $s;
    }
	}
?>