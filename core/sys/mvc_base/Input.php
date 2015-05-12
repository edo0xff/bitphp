<?php namespace BitPHP\Mvc;
  
  /**
  * @author Eduardo B <ms7rbeta@gmail.com>
  * @since bitphp 2.0
  */
  class Input {

    const HMVC_URL_JUMP = 3;
    const MVC_URL_JUMP  = 2;

    /**
    *	@param string $index index of $_params to search
    *	@param boolean $filter optional param, indicates whether to filter html chars, true by default
    *	@return string
    */
    public function urlParam($index, $filter = true)
    {
      global $bitphp;
      $route = $bitphp->route;

      if( is_numeric($index) ) { 
        
        $index += ( $bitphp->config->property('hmvc') ) ? self::HMVC_URL_JUMP : self::MVC_URL_JUMP;
        $string = isset($route['URL'][$index]) && $route['URL'][$index] !== '' ? $route['URL'][$index] : null;
      } else {

        $index = array_search($index, $route['URL']);
        
        if( $index === false ) { return null; }
        if( !isset( $route['URL'][$index + 1] ) ) { return ''; }
        return $route['URL'][$index + 1];
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
