<?php namespace BitPHP\Mvc;
  
  /**
  * @author Eduardo B <ms7rbeta@gmail.com>
  * @since bitphp 2.0
  */
  class Input {

    /**
    *	<p>ONLY WITH BITPHP, gets the value of the specified index in url params, and filters
    *	html chars, return null if index isn't set.</p><p>Url parameters are received here more
    *	easily, however, you can do as in previous versions, for compatibility with applications
    *	developed in previous versions.</p>
    *
    *	@global string $_URLPARAMS this variable contains url parameters
    *	@param string $index index of $_params to search
    *	@param boolean $html_filter optional param, indicates whether to filter html chars, true by default
    *	@return string
    */
    public function urlParam($index, $html_filter = true)
    {
      global $bitphp;
      $_ROUTE = $bitphp->route;

      if( is_numeric($index) ) { 
        $index += ( $bitphp->getProperty('hmvc') ) ? 3 : 2 ;
        $string = isset($_ROUTE['URL'][$index]) && $_ROUTE['URL'][$index] !== '' ? $_ROUTE['URL'][$index] : null;
      } else {
        $index = array_search($index, $_ROUTE['URL']);
        $string = ($index !== false) ? $_ROUTE['URL'][$index + 1] : null ;
      }
    
      return $html_filter && $string !== null ? htmlentities($string, ENT_QUOTES) : $string;
    }

    /**
    *	Gets the value of the specified key in $_POST, and filters
    *	html chars, return null if key isn't set.
    *
    *	@param string $index index of $_POST to search
    *	@param boolean $html_filter optional param, indicates whether to filter html chars, true by default
    *	@return string
    */
    public function post($index, $html_filter = true)
    {
      $string = isset($_POST[$index]) && $_POST[$index] !== '' ? $_POST[$index] : null;
      return $html_filter && $string !== null ? htmlentities($string, ENT_QUOTES) : $string;
    }

    /**
    *	Gets the value of the specified key in $_GET, and filters
    *	html chars, return null if key isn't set.
    *
    *	@param string $index index of $_GET to search
    *	@param boolean $html_filter optional param, indicates whether to filter html chars, true by default
    *	@return string
    */
    public function get($index, $html_filter = true)
    {
      $string = isset($_GET[$index]) && $_GET[$index] !== '' ? $_GET[$index] : null;
      return $html_filter && $string !== null ? htmlentities($string, ENT_QUOTES) : $string;
    }

    /**
    *	Gets the value of the specified key in $_COOKIE, and filters
    *	html chars, return null if key isn't set.
    *
    *	@param string $index index of $_COOKIE to search
    *	@param boolean $html_filter optional param, indicates whether to filter html chars, true by default
    *	@return string
    */
    public function cookie($index, $html_filter = true)
    {
      $string = isset($_COOKIE[$index]) && $_COOKIE[$index] !== '' ? $_COOKIE[$index] : null;
      return $html_filter && $string !== null ? htmlentities($string, ENT_QUOTES) : $string;
    }
  }