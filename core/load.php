<?php
  namespace BitPHP;
  use Exception;
  /**
  *	Provides methods for load views, libraries, models and controllers.
  *
  *	You could say that is the heart of BitPHP, because this class is what allows
  *	working with views, models and controllers.
  *
  *	@author Eduardo B <ms7rbeta@gmail.com>
  *	@version stable 1.5.0
  *	@package BitPHP
  *	@copyright 2014 Root404 Co.
  *	@website http://bitphp.root404.com <contacto@root404.com>
  *	@license GNU/GPLv3
  */
  class Load 
  {

    /**
    *	Includes the specified file if it exists, and if the specified class is inside the file.
    *
    *	@param string $f Path and file name to be loaded, passed by reference.
    *	@param string $c Class that should exist inside the file.
    *	@throws FileNotExist if the file does not exist
    *	@throws ClassNotFound the file exist, but does not contain the proper class
    *	@return void
    */
    private static function include_file(&$f, $c) {
      if( file_exists($f) ) {
	require($f);
	if( !$c || class_exists($c) ) {
	  return 1;
	} else {
	  throw new Exception('La clase <b>'.$c.'</b> no existe dentro del fichero <b>'.$f.'</b>.');
	}
      } else {
	throw new Exception('El fichero <b>'.$f.'</b> no existe');
      }
    }

    /**
    *	Attempts to load the specified library, if successful returns an object of this.
    *
    *	@param string $_name Name of the library to be loaded, without extension.
    *	@param mixed $_params Parameters that could ever need the constructor of the class library.
    *	@return object
    *	@example /var/www/docs/examples/Load_library.php
    */
    public static function library($_name, $_params = Null) {
      $file = 'app/libraries/'.$_name.'.php';
      try {
	self::include_file($file, $_name);
	$_instance = new $_name($_params);
	return $_instance;
      }	catch(Exception $e) {
	$d = 'La libreria <b>'.$_name.'</b> no se pudo cargar';
	$c = $e->getMessage();
	\BitPHP\Error::trace($d, $c);
      }
    }

    /**
    *	Try loading the driver indicated, only used by bitphp core.
    *
    *	@param string $_name Name of the controller to be loaded, without extension, passed by reference.
    *	@return object
    */
    public static function controller(&$_name) {
      $file = 'app/controllers/'.$_name.'.php';
      try {
	\BitPHP\Load::include_file($file, $_name);
	$_instance = new $_name();
	return $_instance;
      } catch(Exception $e) {
	 $d = 'El controlador <b>'.$_name.'</b> no se pudo cargar.';
	 $c = $e->getMessage();
	 \BitPHP\Error::trace($d, $c, False);
      }
    }

    /**
    *	Try loading the model indicated.
    *
    *	@param string $_name Name of the model to be loaded, without extension.
    *	@return object
    *	@example /var/www/docs/examples/Load_model.php
    */
    public static function model($_name) {
      $file = 'app/models/'.$_name.'.php';
      try {
	\BitPHP\Load::include_file($file, $_name);
	$_instance = new $_name();
	return $_instance;
      } catch(Exception $e) {
	$d = 'El modelo <b>'.$_name.'</b> no se pudo cargar.';
	$c = $e->getMessage();
	\BitPHP\Error::trace($d, $c);
      }
    }
    
    /**
    *	Attempts to load and display the specified view.
    *
    *	@param mixed $_names Name of the view(s) to be loaded, without extension.
    *	@param array $_params Associative array of parameters (name => value), that may use the view.
    *	@return void
    *	@example /var/www/docs/examples/Load_view.php
    */
    public static function view($_names, $_params = Null) {

      if(!is_array($_names)) {
	$_names = [$_names];
      }

      if($_params) {
	foreach($_params as $_var => $_val) {
	  $$_var = $_val;
	}
      }
      
      foreach($_names as $_view) {
	$file = 'app/views/'.$_view.'.php';
	if(file_exists($file)) {
	  require($file);
	} else {
	  $d = 'La vista <b>'.$_view.'</b> no se pudo cargar.';
	  $c = 'El fichero <b>'.$file.'</b> no existe.';
	  \BitPHP\Error::trace($d, $c);
	}
      }
    }
    
  }
?>