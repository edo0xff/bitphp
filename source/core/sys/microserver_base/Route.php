<?php namespace BitPHP\MicroServer;

	class Route {

		public static function parseRoute( $route = null ) {
			global $bitphp;

			//BASE_PATH
			$path = $bitphp->getEnviromentProperty('base_path');
			$len = strlen( $path ) - 1;
      		$path = ( $path[ $len ] == '/' ) ? substr( $path, 0, $len) : $path ;
      		$_ROUTE['BASE_PATH'] = $path;

			//APP_PATH
			$_ROUTE['APP_PATH'] = 'app';

			//SERVER NAME
			$_ROUTE['SERVER_NAME'] = ( empty( $_SERVER['HTTPS'] ) ? 'http://' : 'https://' ) . $_SERVER['SERVER_NAME'];

			//APP_LINK
			$_ROUTE['APP_LINK'] = $_ROUTE['SERVER_NAME'] . $_ROUTE['BASE_PATH'];

			//PUBLIC_PATH_LINK
			$_ROUTE['PUBLIC'] = $_ROUTE['SERVER_NAME'] . $_ROUTE['BASE_PATH'] . '/public';

			$bitphp->route = $_ROUTE;
		}
	}
?>