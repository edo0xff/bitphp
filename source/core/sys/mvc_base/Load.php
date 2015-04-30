<?php namespace BitPHP\Mvc;

  use Exception;
  use \BitPHP\Mvc\Route;

  /**
  *	@author Eduardo B <ms7rbeta@gmail.com>
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
    private function include_file( &$_f, $_c ) {
      if( file_exists( $_f ) ) {
        require_once( $_f );
        if( class_exists( $_c ) ) {
          return 1;
        } else {
          throw new Exception('La clase <b>'.$_c.'</b> no existe dentro del fichero <b>'.$_f.'</b>.');
        }
      } else {
        throw new Exception('El fichero <b>'.$_f.'</b> no existe.');
      }
    }

    /**
     *  Carga los modulos registrados para carga automatica
     *
     *  @return void
     */
    public function auto() {
      global $bitphp;
      $modules = $bitphp->getProperty('autoload_modules');

      $_n = count( $modules );
      for ( $_i = 0; $_i < $_n; $_i++ ) {
        self::module( $modules[ $_i ] );
      }
    }

    /**
    *	Attempts to include the specified module.
    *
    *	@param string $_name Name of the module to be loaded, without extension.
    *	@return void
    */
    public function module( $_name, $_register_as = null ) {
      global $bitphp;
      $_file = 'core/modules/'. $_name .'.php';

      if( file_exists( $_file ) ){
          require_once( $_file );
          $_register_as = $_register_as ? $_register_as : strtolower( $_name ) ;
          $bitphp->controller->$_register_as = new $_name();
      }	else {
        $_d = 'El modulo <b>'.$_name.'</b> no se pudo cargar.';
        $_c = 'El fichero <b>'.$_file.'</b> no existe.';
        $bitphp->error->trace($_d, $_c);
      }
    }

    /**
     *  Ejecuta un controlador/accion ya sea de otra applicacion (HMVC) o simplemente
     *  otro controlador (MVC)
     *
     *  @param string $_app Controlador que se va ejecutar, eg. ..run('app/controller1/acction1') //hmvc
     *                      ..run('controller1/acction1') //mvc
     *  @param bool $echo = true  Indica si debe haber salida de datos por parte del controlador o el resultado
     *                            debe ser retornado para poder usarlo como variable. 
     *                            eg. $var = ..run('app/controller/acction', false);
     *                            eg. ..run('app/controller/acction');
     *  @return mixed
     */
    public function run( $_app_, $echo = true ) {
      global $bitphp;
      $_TEMP_BITPHP_CONTROLLER = $bitphp->controller;
      $_TEMP_ROUTE = $bitphp->route;

      $bitphp->route = Route::parse_route( $_app_ );
      $_CONTROLLER = $bitphp->route['APP_CONTROLLER'];
      $_ACCTION = $bitphp->route['APP_ACCTION'];

      if( !$echo ) {
        ob_start();
      }

      $bitphp->controller = self::controller( $_CONTROLLER, $_ACCTION );
      self::auto();

      $bitphp->controller->$_ACCTION();

      $bitphp->route = $_TEMP_ROUTE;
      $bitphp->controller = $_TEMP_BITPHP_CONTROLLER;

      return $echo ? null : ob_get_clean();
    }

    /**
    *	Try loading the controller indicated, only used by bitphp core.
    *
    *	@param string $_name Name of the controller to be loaded, without extension, passed by reference.
    * @param string $_method Nombre del metodo (accion) del controlador a ejecutar
    *	@return void
    */
    public function controller($_name, $_method) {
      global $bitphp;
      $_ROUTE = $bitphp->route;

      $_file = $_ROUTE['APP_PATH'] .'/controllers/'.$_name.'.php';
      try {
        self::include_file($_file, $_name);
        if( method_exists($_name, $_method) ) {
          $_instance = new $_name();
          return $_instance;
        } else {
          $d = 'Error en controlador <b>'. $_name .'</b>.';
          $m = 'No contiene la accion <b>'. $_method .'()</b>.';
          $bitphp->error->trace($d, $m, False);
        }
      } catch(Exception $_e) {
        $_d = 'El controlador <b>'.$_name.'</b> no se pudo cargar.';
        $_c = $_e->getMessage();
        $bitphp->error->trace($_d, $_c, False);
      }
    }

    /**
    *	Try loading the model indicated.
    *
    *	@param string $_name Name of the model to be loaded, without extension.
    *	@return object
    */
    public function model( $_name ) {
      global $bitphp;
      $_ROUTE = $bitphp->route;

      $_file = $_ROUTE['APP_PATH'] .'/models/'.$_name.'.php';
      try {
        self::include_file($_file, $_name);
        return new $_name();
      } catch(Exception $_e) {
        $_d = 'El modelo <b>'.$_name.'</b> no se pudo cargar.';
        $_c = $_e->getMessage();
        $bitphp->error->trace($_d, $_c);
      }
    }

    /**
    *	Attempts to load and display the specified view.
    *
    *	@param mixed $_names Name of the view(s) to be loaded, without extension.
    *	@param array $_params Associative array of parameters (name => value), that may use the view.
    *	@return void
    */
    public function view($_names, $_params = array()) {
      global $bitphp;
      $_ROUTE = $bitphp->route;

      $_names = is_array($_names) ? $_names : [$_names];
      $_i = count($_names);

      extract($_params);
      $_JS_ROUTE = '<script>var _ROUTE = jQuery.parseJSON(\'' . json_encode( $_ROUTE ) . '\')</script>';

      for($_j = 0; $_j < $_i; $_j++) {
        $_file = $_ROUTE['APP_PATH'] .'/views/'.$_names[$_j].'.php';
        if(file_exists($_file)) {
          require($_file);
        } else {
          $_d = 'La vista <b>'.$_names[$_j].'</b> no se pudo cargar.';
          $_c = 'El fichero <b>'.$_file.'</b> no existe.';
          $bitphp->error->trace($_d, $_c);
        }
      }
    }

  }
?>
