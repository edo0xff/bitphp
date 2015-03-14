<?php namespace BitPHP;

  use Exception;
  use \BitPHP\Load;
  use \BitPHP\Response;
  use \BitPHP\Config;

  /**
  *	Static class that provides methods for trace app's errors
  *
  *	Through this class is why BitPHP ends the execution of the application
  *	if there was an error and shows you where the problem is.
  *	
  *	@author Eduardo B <ms7rbeta@gmail.com>
  *	@version 3.0.0
  * @package Core
  *	@copyright 2014 Root404 Co.
  *	@website http://bitphp.root404.com <contacto@root404.com>
  *	@license GNU/GPLv3
  */
  class Error
  {

  /**
    *	Trace errors and terminate the app, normally only used by bitphp's core
    *
    *	@param string $d error's description, passed by reference
    *	@param string $e error's exception message, passed by reference
    *	@param boolean $trace indicates whether the error should be traced
    *	@return void
    */
    public static function trace(&$d, &$e, $print_trace = true) {
      global $_APP;
      $ex = new Exception();
      $trace = $ex->getTrace();

      if(Config::php_errors()){

        $params = [
            'description' => $d
          , 'exception' => $e
          , 'print_trace' => $print_trace
          , 'trace' => $trace
        ];
        
        if( Config::ERR_VIEW ) {
          Load::view(Config::ERR_VIEW, $params);
        } else {
          echo $d, '<br>', $e, '<br>';
          echo $print_trace ? '<pre>'. json_encode($trace[2], JSON_PRETTY_PRINT) .'</pre>' : null ;
        }
      } else {
        Response::not_found();
      }
      exit;
    }
  }
?>