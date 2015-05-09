<?php namespace BitPHP\Mvc;
  
  /**
  * @author Eduardo B <ms7rbeta@gmail.com>
  * @since bitphp 2.0
  */
  class Input {

    /**
    *	@param string $index index of $_params to search
    *	@param boolean $filter optional param, indicates whether to filter html chars, true by default
    *	@return string
    */
    public function urlParam($index, $filter = true)
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
    
      return $filter && $string !== null ? htmlentities($string, ENT_QUOTES) : $string;
    }

    /**
    *	@param string $index index of $_POST to search
    *	@param boolean $filter optional param, indicates whether to filter html chars, true by default
    *	@return string
    */
    public function post($index, $filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS)
    {
      if( $filter === false ) { $filter = FILTER_DEFAULT; }
      return filter_input(INPUT_POST, $index, $filter);
    }

    /**
    *	@param string $index index of $_GET to search
    *	@param boolean $filter optional param, indicates whether to filter html chars, true by default
    *	@return string
    */
    public function get($index, $filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS)
    {
      if( $filter === false ) { $filter = FILTER_DEFAULT; }
      return filter_input(INPUT_GET, $index, $filter);
    }

    /**
    *	@param string $index index of $_COOKIE to search
    *	@param boolean $filter optional param, indicates whether to filter html chars, true by default
    *	@return string
    */
    public function cookie($index, $filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS)
    {
      if( $filter === false ) { $filter = FILTER_DEFAULT; }
      return filter_input(INPUT_COOKIE, $index, $filter);
    }
  }
