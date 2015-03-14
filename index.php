<?php

  /**
   *	BitPHP - Micro MVC Framework
   *
   *	Are you starting in the MVC development? I present a small tool that
   *	will help you understand, through practice, the operation of this
   *	paradigm is small, friendly, easy to use, and therefore easy to learn.
   *
   *	@author Eduardo B <ms7rbeta@gmail.com>
   *	@version beta 2.0.0
   *	@copyright 2014 Root404 Co.
   *	@website http://bitphp.root404.com <contacto@root404.com>
   *	@license GNU/GPLv3
   */
  
  require('core/config.php');
  require('core/errors.php');
  require('core/load.php');
  require('core/database.php');
  require('core/input.php');
  require('core/response.php');
  require('core/route.php');

  if( !\BitPHP\Config::php_errors() ) {
    error_reporting(0);
    ini_set('display_errors', '0');
  }

  \BitPHP\Load::auto();

  $_URL = \BitPHP\Route::parse_route();
  $_APP = \BitPHP\Route::app_path( $_URL );

  $method = \BitPHP\Route::get_method( $_URL );
  $controller = \BitPHP\Route::get_controller( $_URL );
  $controller_obj = \BitPHP\Load::controller( $controller ) ;

  if( method_exists($controller, $method) ) {
    $controller_obj->$method();
  } else {
    $d = 'Error en controlador <b>'. $controller .'</b>';
    $m = 'No contiene el metodo <b>'. $method .'()</b>';
    \BitPHP\Error::trace($d, $m, False);
  }
?>