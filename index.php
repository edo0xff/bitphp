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
  require('core/errors.php');
  require('core/config.php');
  require('core/load.php');
  require('core/database.php');
  require('core/input.php');

  if(!\BitPHP\Config::DISPLAY_PHP_ERRORS) {
    error_reporting(0);
    ini_set('display_errors', '0');
  }

  $_GET['bit_url'] = empty($_GET['bit_url']) ? \BitPHP\Config::DEFAULT_CONTROLLER : $_GET['bit_url'];

  /** @var array $_URLPARAMS associative array contains the parameters received by the url */
  $_URLPARAMS = explode('/', $_GET['bit_url']);
  $controller = \BitPHP\Load::controller($_URLPARAMS[0]);

  $_URLPARAMS[1] = empty($_URLPARAMS[1]) ? 'index' : $_URLPARAMS[1];

  if(method_exists($controller, $_URLPARAMS[1])) {
    $method = $_URLPARAMS[1];
    $controller->$method();
  } else {
    $d = 'Error en controlador <b>'.$_URLPARAMS[0].'</b>';
    $m = 'No contiene el metodo <b>'.$_URLPARAMS[1].'()</b>';
    \BitPHP\Error::trace($d, $m, False);
  }
?>