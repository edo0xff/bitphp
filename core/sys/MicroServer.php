<?php namespace BitPHP\Apps;

	require 'core/sys/microserver_base/CleanData.php';
	require 'core/sys/microserver_base/Route.php';
	require 'core/sys/microserver_base/PatternParser.php';

	use \Exception;
	use \Closure;
	use \RunTimeException;
	use \BitPHP\MicroServer\Route;
	use \BitPHP\MicroServer\CleanData;
	use \BitPHP\MicroServer\PatternParser as Pattern;

	class MicroServer {

		private $newFunctions = array();
		protected $routes = array();
		public $requestData;

		public function __construct() {
			global $bitphp;
			
      		$bitphp->route = Route::parseRoute();
      		$this->route = $bitphp->route['MICRO_ROUTE'];
      		$this->requestData = CleanData::filter( $_REQUEST );
		}

		public function __call( $methodName, array $args ) {
			if( isset( $this->newFunctions[ $methodName ] ) ) {
				return call_user_func_array( $this->newFunctions[ $methodName ], $args );
			}

			throw new RunTimeException("El metodo $methodName() no existe dentro de la instancia de la aplicacion.");
		}

		public function request( $index ) {
			return !empty( $this->requestData[$index] ) ? $this->requestData[$index]  :  null;
		}

   		public function set( $item, $value ) {
			
			if( !is_callable( $value ) ) {
				$this->$item = $value;
				return 1;
			}

			$this->newFunctions[ $item ] = Closure::bind( $value, $this, get_class() );
		}

		public function route( $route, $callback ) {

			$pattern = Pattern::create( $route );
			$this->routes[$pattern] = $callback;
		}

		public function run( $routes = null ) {

			$routes = $routes !== null ? $routes : $this->routes;

			foreach ($routes as $pattern => $callback) {
				if (@preg_match( $pattern, $this->route, $params )) {
					array_shift($params);
					return call_user_func_array($callback, array_values($params));
				}
			}

			throw new Exception("Error Processing Request: 404", 1);
		}
	}