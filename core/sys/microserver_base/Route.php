<?php namespace BitPHP\MicroServer;

	use \BitPHP\MicroServer\CleanData;

	class Route {

		// Parametros qué utilizan, las vistas por ejemplo
		private static function getBasePath() {
			global $bitphp;

			$path = $bitphp->config->environmentProperty('base_path');
			//to strip last slash
			$len = strlen( $path ) - 1;
      		$path = ( $path[ $len ] == '/' ) ? substr( $path, 0, $len) : $path ;
      		return $path;
		}

		private function getRealServerName() {
			return ( empty( $_SERVER['HTTPS'] ) ? 'http://' : 'https://' ) . $_SERVER['SERVER_NAME'];
		}

		private static function getMicroRoute() {
			$route = empty($_GET['_route']) ? '/' : '/' . $_GET['_route'];
			$route = CleanData::filter( $route );
			// to strip last slash
			$len = strlen( $route ) - 1;
      		$route = ( $len > 1 && $route[ $len ] == '/' ) ? substr( $route, 0, $len) : $route;
      		return $route;
		}

		public static function parseRoute( $route = null ) {

			//BASE_PATH
      		$_ROUTE['BASE_PATH'] = self::getBasePath();
			//APP_PATH
			$_ROUTE['APP_PATH'] = 'app';
			//SERVER NAME
			$_ROUTE['SERVER_NAME'] = self::getRealServerName();
			//APP_LINK
			$_ROUTE['APP_LINK'] = $_ROUTE['SERVER_NAME'] . $_ROUTE['BASE_PATH'];
			//PUBLIC_PATH_LINK
			$_ROUTE['PUBLIC'] = $_ROUTE['SERVER_NAME'] . $_ROUTE['BASE_PATH'] . '/public';
			//MICRO_ROUTE
			$_ROUTE['MICRO_ROUTE'] = self::getMicroRoute();
			return $_ROUTE;
		}
	}