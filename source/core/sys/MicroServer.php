<?php namespace BitPHP\Apps;

	require( 'core/sys/microserver_base/Route.php' );
	require( 'core/sys/modules/Template.php' );
	require( 'core/sys/bitphp_base/DataBase.php' );
	require( 'core/sys/modules/Crud.php' );

	use \Exception;
	use \Closure;
	use \RunTimeException;
	use \BitPHP\MicroServer\Route as MicroRoute;

	class MicroServer {

		private $newFunctions = array();
		protected $routes = array();
		public $requestData;
		public $template;

		public function __construct() {

			$this->route = empty($_GET['_route']) ? '/' : '/' . $_GET['_route'];
			$this->route = $this->cleanData( $this->route );

			/* para eliminar el slash al final de la ruta, para que "/la_wea" se igual a "/la_wea/" */
			$len = strlen( $this->route ) - 1;
      		$this->route = ( $len > 1 && $this->route[ $len ] == '/' ) ? substr( $this->route, 0, $len) : $this->route ;

      		MicroRoute::parseRoute();
			$this->template = new \Template();

      		$this->requestData = $this->cleanData( $_REQUEST );
		}

		public function __call( $methodName, array $args ) {
			if( isset( $this->newFunctions[ $methodName ] ) ) {
				return call_user_func_array( $this->newFunctions[ $methodName ], $args );
			}

			throw new RunTimeException("El metodo $methodName() no existe dentro de la instancia de la aplicacion.");
		}

		public function request( $index ) {
			return !empty( $this->requestData[$index] ) ? $this->requestData[$index]  :  null ;
		}

		public function cleanData( $_something ) {
     		$data = null;

     		if( is_array( $_something ) ) {
       			$data = array();
       			foreach ($_something as $key => $value) {
         			$data[ $key ] = $this->cleanData( $value );
	       		}
     		} else {
       			$data = trim( htmlentities( $_something, ENT_QUOTES ) );
     		}

	    	return $data;
   		}

   		public function set( $item, $value ) {
			
			if( !is_callable( $value ) ) {
				$this->$item = $value;
				return 1;
			}

			$this->newFunctions[ $item ] = Closure::bind( $value, $this, get_class() );
		}

		public function loadModel( $model_name ) {

			$model_name = explode( ' as ', $model_name);
			if( count( $model_name ) > 1 ) {
				$load_as = $model_name[1];
				$model_name = $model_name[0];
			} else {
				$model_name = $model_name[0];
				$load_as = strtolower( $model_name );
			}

			$file = "app/models/$model_name.php";

			if( !file_exists( $file ) ) {
				throw new Exception("Error Loading Model: file $model_name don't exists", 1);
			}

			require_once( $file );
			$this->$load_as = new $model_name();
		}

		public function loadModule( $module_name ) {

			$module_name = explode( ' as ', $module_name);
			if( count( $module_name ) > 1 ) {
				$load_as = $module_name[1];
				$module_name = $module_name[0];
			} else {
				$module_name = $module_name[0];
				$load_as = strtolower( $module_name );
			}

			$file = "core/modules/$module_name.php";

			if( !file_exists( $file ) ) {
				throw new Exception("Error Loading Module: file $module_name don't exists", 1);
			}

			require_once( $file );
			$this->$load_as = new $module_name();
		}

		public function createPattern( $pattern ) {

			$search = [
				  '/'
				, ':word'
				, ':number'
				, ':any'
			];

			$replace = [
				  '\/'
				, '(\w+)'
				, '(\d+)'
				, '(.*)'
			];

			return '/^' . str_replace( $search, $replace, $pattern ) . '$/';
		}

		public function route( $route, $callback ) {

			$pattern = $this->createPattern( $route );
			$this->routes[$pattern] = $callback;
		}

		public function run( $routes = null ) {

			$routes = $routes !== null ? $routes : $this->routes;

			foreach ($routes as $pattern => $callback) {
				if (preg_match($pattern, $this->route, $params)) {
					array_shift($params);
					return call_user_func_array($callback, array_values($params));
				}
			}

			throw new \Exception("Error Processing Request: 404", 1);
		}
	}
?>