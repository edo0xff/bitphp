<?php namespace BitPHP;

  use Exception;
  use \BitPHP\Error;
  use \BitPHP\Config;
  use \BitPHP\Route;

  /**
  *	Provides methods for load views, libraries, models and controllers.
  *
  *	You could say that is the heart of BitPHP, because this class is what allows
  *	working with views, models and controllers.
  *
  *	@author Eduardo B <ms7rbeta@gmail.com>
  *	@version beta 1.6.0
  * @package Core
  *	@copyright 2014 Root404 Co.
  *	@website http://bitphp.root404.com <contacto@root404.com>
  *	@license GNU/GPLv3
  */
  class Load 
  {

    /**
    *	Includes the specified file if it exists, and if the specified class is inside the file.
    *
    *	@param string $_f Path and file name to be loaded, passed by reference.
    *	@param string $_c Class that should exist inside the file.
    *	@throws FileNotExist if the file does not exist
    *	@throws ClassNotFound the file exist, but does not contain the proper class
    *	@return void
    */
    private static function include_file(&$_f, $_c) {
      if( file_exists($_f) ) {
        require_once($_f);
        if( !$_c || class_exists($_c) ) {
          return 1;
        } else {
          throw new Exception('La clase <b>'.$_c.'</b> no existe dentro del fichero <b>'.$_f.'</b>.');
        }
      } else {
        throw new Exception('El fichero <b>'.$_f.'</b> no existe');
      }
    }

    public static function auto() {
      $_n = count(Config::$AUTO_LOAD);

      for ($_i = 0; $_i < $_n; $_i++) { 
        self::module(Config::$AUTO_LOAD[$_i]);
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
    public static function module($_name) {
      $_file = 'core/modules/'. $_name .'.php';

      try {
        self::include_file($_file, $_name);
      }	catch(Exception $_e) {
        $_d = 'El modulo <b>'.$_name.'</b> no se pudo cargar';
        $_c = $_e->getMessage();
        Error::trace($_d, $_c);
      }
    }

    /**
    *	Try loading the driver indicated, only used by bitphp core.
    *
    *	@param string $_name Name of the controller to be loaded, without extension, passed by reference.
    *	@return object
    */
    public static function controller(&$_name) {
      global $_APP;
      $_file = $_APP .'/controllers/'.$_name.'.php';
      try {
        self::include_file($_file, $_name);
        $_instance = new $_name();
        return $_instance;
      } catch(Exception $_e) {
        $_d = 'El controlador <b>'.$_name.'</b> no se pudo cargar.';
        $_c = $_e->getMessage();
        Error::trace($_d, $_c, False);
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
      global $_APP;
      $_file = $_APP .'/models/'.$_name.'.php';
      try {
        self::include_file($_file, $_name);
        $_instance = new $_name();
        return $_instance;
      } catch(Exception $_e) {
        $_d = 'El modelo <b>'.$_name.'</b> no se pudo cargar.';
        $_c = $_e->getMessage();
        Error::trace($_d, $_c);
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
    public static function view($_names, $_params = array()) {

      global $_APP;
      $_names = is_array($_names) ? $_names : [$_names];
      $_i = count($_names);

      extract($_params);

      for($_j = 0; $_j < $_i; $_j++) {
        $_file = $_APP .'/views/'.$_names[$_j].'.php';
        if(file_exists($_file)) {
          require($_file);
        } else {
          $_d = 'La vista <b>'.$_names[$_j].'</b> no se pudo cargar.';
          $_c = 'El fichero <b>'.$_file.'</b> no existe.';
          Error::trace($_d, $_c);
        }
      }
    }
    
  }
?>