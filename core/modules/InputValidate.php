<?php use \BitPHP\Mvc\Input;

  /**
  * @author Eduardo B <ms7rbeta@gmail.com>
  */
	class InputValidate extends Input {

    //Error codes
    const PASS_DONT_MATCH = 445;
    const PASS_ISNT_SECURE = 446;
    const IS_NOT_EMAIL = 235;
    const IS_NOT_NUMERIC = 237;

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
          $string = self::post($k, $f);
          break;
        case 'GET':
          $string = self::get($k, $f);
          break;
        case 'COOKIE':
          $string = self::cookie($k, $f);
          break;
        case 'URL_PARAM':
          $string = self::urlParam($k, $f);
          break;
        case null:
          $string = $k;
          break;
      }

      return $string;
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
      $string1 = self::getValue($m, $k[0]);
      $string2 = self::getValue($m, $k[1]);
      
      if($string1 === null || $string2 === null){ return null; }
      if($string1 != $string2) { return 445; }

      $match = preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $string1);
      if(!$match){ return 446; }

      return $cryp ? hash($hash, $string1) : $string1;
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
      $string = self::getValue($m, $k);

      if($string === null){ return null; }

      $match = preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/',$string);
      return $match ? $string : 235;
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
      $string = self::getValue($m, $k);
      if( $string === null ){ return null; }

      if(is_numeric($string)) {
        switch(strtoupper($t)) {
          case 'INT':
            return intval($string);
          case 'FLOAT':
            return floatval($string);
          case null:
            return $string;
        }
      } else {
        return 237;
      }
    }
	}