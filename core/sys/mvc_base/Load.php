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
    *	@param string $_file Path and file name to be loaded, passed by reference.
    *	@param string $_c Class that should exist inside the file.
    *	@throws FileNotExist if the file does not exist
    *	@throws ClassNotFound the file exist, but does not contain the proper class
    *	@return void
    */
    private function checkClassCoherency( &$_file, $_class ) {
      if( file_exists( $_file ) )  {
        require_once( $_file );
        if( class_exists( $_class ) ) {
          return 1;
        } else {
          throw new Exception('La clase <b>'.$_class.'</b> no existe dentro del fichero <b>'.$_file.'</b>.');
        }
      } else {
        throw new Exception('El fichero <b>'.$_file.'</b> no existe.');
      }
    }

    /**
     *  Carga los modulos registrados para carga automatica
     *
     *  @return void
     */
    public function auto() {
      global $bitphp;
      $modules = $bitphp->config->property('autoload_modules');

      $modules_count = count( $modules );
      for ( $i = 0; $i < $modules_count; $i++ ) {
        self::module( $modules[ $i ] );
      }
    }

    /**
    *	Attempts to include the specified module.
    *
    *	@param string $_name Name of the module to be loaded, without extension.
    *	@return void
    */
    public function module( $_name, $_register_as = null, $_contruct_parameters = null ) {
      global $bitphp;
      $_file = 'core/modules/'. $_name .'.php';

      if( file_exists( $_file ) )
      {
          require_once( $_file );
          if( $_register_as === false ) { return; }

          $module_obj = new $_name( $_contruct_parameters );
          if( $bitphp->controller === null ) { return $module_obj; }

          $_register_as = $_register_as ? $_register_as : strtolower( $_name ) ;
          $bitphp->controller->$_register_as = $module_obj;
      }	
        else 
      {
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

      if( !$echo ) { ob_start(); }

      $bitphp->controller = self::controller( $_CONTROLLER, $_ACCTION );
      
      self::auto();
      $bitphp->controller->$_ACCTION();

      //reset normal values
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

      $_file = $bitphp->route['APP_PATH'] .'/controllers/'.$_name.'.php';

      try 
      {
        self::checkClassCoherency($_file, $_name);        
        if( method_exists($_name, $_method) ) 
        {
          $_instance = new $_name();
          return $_instance;
        } 
          else 
        {
          $d = 'Error en controlador <b>'. $_name .'</b>.';
          $m = 'No contiene la accion <b>'. $_method .'()</b>.';
          $bitphp->error->trace($d, $m, False);
        }
      } 
        catch(Exception $_e) 
      {
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
    public function model( $_name, $_register_as = null ) {
      global $bitphp;
      $_file = $bitphp->route['APP_PATH'] .'/models/'.$_name.'.php';

      try 
      {
        self::checkClassCoherency($_file, $_name);
        if( $_register_as === false ) { return; }

        $model_obj = new $_name();
        if( $bitphp->controller === null ) { return $model_obj; }

        $_register_as = $_register_as ? $_register_as : strtolower( $_name ) ;
        $bitphp->controller->$_register_as = $model_obj;
      } 
        catch(Exception $_e) 
      {
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
      extract($_params);

      $_names = is_array($_names) ? $_names : [$_names];
      $_number_of_views = count($_names);

      for( $_view_index = 0; $_view_index < $_number_of_views; $_view_index++ )
      {
        $_file = $_ROUTE['APP_PATH'] .'/views/'.$_names[$_view_index].'.php';

        if(file_exists($_file)) {
          require($_file);
        } else {
          $description = 'La vista <b>'.$_names[$_view_index].'</b> no se pudo cargar.';
          $exception = 'El fichero <b>'.$_file.'</b> no existe.';
          $bitphp->error->trace( $description, $exception );
        }
      }
    }

  }