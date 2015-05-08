<?php namespace BitPHP\Apps;

	require( 'core/sys/microserver_base/Route.php' );
	require( 'core/sys/bitphp_base/DataBase.php' );

	use \Exception;
	use \Closure;
	use \RunTimeException;
	use \BitPHP\MicroServer\Route as MicroRoute;

	class MicroServer {

		private $newFunctions = array();
		protected $routes = array();
		public $requestData;

		public function __construct() {

			$this->route = empty($_GET['_route']) ? '/' : '/' . $_GET['_route'];
			$this->route = $this->cleanData( $this->route );

			/* para eliminar el slash al final de la ruta, para que "/la_wea" se igual a "/la_wea/" */
			$len = strlen( $this->route ) - 1;
      		$this->route = ( $len > 1 && $this->route[ $len ] == '/' ) ? substr( $this->route, 0, $len) : $this->route ;

      		MicroRoute::parseRoute();
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
				if (@preg_match($pattern, $this->route, $params)) {
					array_shift($params);
					return call_user_func_array($callback, array_values($params));
				}
			}

			throw new \Exception("Error Processing Request: 404", 1);
		}
	}