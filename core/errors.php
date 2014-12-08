<?php
  namespace BitPHP;
  use Exception;
  /**
  *	Static class that provides methods for trace app's errors
  *
  *	Through this class is why BitPHP ends the execution of the application
  *	if there was an error and shows you where the problem is.
  *	
  *	@author Eduardo B <ms7rbeta@gmail.com>
  *	@version beta 2.0.0
  *	@package BitPHPCore
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
    *	@todo you can send the errors parameters to a view, for a custom error page
    *	@return void
    */
    public static function trace(&$d, &$e, $show_trace = True) {
      $ex = new Exception();
      $trace = $ex->getTrace();

      \BitPHP\Load::view('core/error/header');
      if(\BitPHP\Config::DISPLAY_PHP_ERRORS){
	\BitPHP\Load::view('core/error/description',['d' => $d,'e' => $e]);
	if($show_trace){
	  \BitPHP\Load::view('core/error/trace',['trace' => $trace]);
	}
      } else {
	\BitPHP\Load::view('core/error/404',['d' => $d,'e' => $e,'trace' => $trace]);
      }
      \BitPHP\Load::view('core/error/footer');
      exit;
    }
    
  }
?>