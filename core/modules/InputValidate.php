<?php use \BitPHP\Input;

	class InputValidate extends Input {

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

    public static function clean_blacklist($m, $k) {
      $s = self::get_value($m, $k, false);

      if(!$s){ return null; }

      $blackList = @file_get_contents('app/resources/WordBlackList');

      if(!$blackList) {
        $m = 'No se pudo cargar el archivo de lista negra';
        $e = 'El archivo <b>app/resources/TagBlackList</b> no existe';
        \BitPHP\Error::trace($m, $e);
      }

      $elements = split("\n", $blackList);
      $search = [];
      $replace = [];
      $i = 0;

      foreach ($elements as $e) {
        if(!empty($e) && ($e[0] != '#')) {
          $e = split(':', $e);

          switch ($e[0]) {
            case 'tag':
              //open tag, eg. <b>
              $search[$i] = '<' . $e[1];
              $replace[$i] = '<no-' . $e[1];
              $i++;
              //close tag, eg. </b>
              $search[$i] = '</' . $e[1];
              $replace[$i] = '</no-' . $e[1];
              break;
            
            case 'attr':
              $search[$i] = $e[1] . '=';
              $replace[$i] = 'no-' . $e[1] . '=';
              break;

            case 'rude':
              $search[$i] = $e[1];
              $replace[$i] = '<b>%#$*</b>';
              break;
          }
        }
        $i++;
      }//endforeach

      $s = str_replace($search, $replace, $s);

      //to search in uppercase
      $search = array_map('strtoupper', $search);
      $s = str_replace($search, $replace, $s);      

      return $s;
    }
	}
?>