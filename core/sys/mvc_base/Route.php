<?php namespace BitPHP\Mvc;

	class Route {

		private static function validateAppPath( $app ) {
			global $bitphp;

			if( !is_dir( $app ) ) {
				$description = 'Oops! hubo un problema al ejecutar la aplicacion.';
				$exception = "La carpeta de la aplicacion \"$app\" no existe.";
				$bitphp->error->trace($description, $exception);
			}

			return $app;
		}

		private function getBasePath() {
			global $bitphp;
			$path = $bitphp->config->environmentProperty('base_path');
			// to strip last slash
			$len = strlen( $path ) - 1;
			$path = ( $path[ $len ] == '/' ) ? substr( $path, 0, $len) : $path ;
			return $path;
		}

		private function getUrl( $route ) {
			//URL array
			if ( !$route ) {
				$url =  empty($_GET['_route']) ? array() : explode('/', $_GET['_route']);
			} else {
				$url = explode('/', $route);
			}
			return $url;
		}

		private function getAppPath( $url ) {
			global $bitphp;
			$app_path = 'app';

			if( $bitphp->config->property('hmvc') ) {
				$app_path .= '/' . ( empty( $url[0] ) ? $bitphp->config->property('main_app') : $url[0] );
			}
			//validate app
			self::validateAppPath( $app_path );
			return $app_path;
		}

		private function getAppController( $url ) {
			global $bitphp;
			$index = ( $bitphp->config->property('hmvc') ) ? 1 : 0 ;
			return empty( $url[$index] ) ? $bitphp->config->property('main_controller') : $url[$index];
		}

		private function getAppAction( $url ) {
			global $bitphp;
			$index = ( $bitphp->config->property('hmvc') ) ? 2 : 1 ;
			return empty( $url[$index] ) ? $bitphp->config->property('main_action') : $url[$index];
		}

		public function getFullServerName() {
			return ( empty( $_SERVER['HTTPS'] ) ? 'http://' : 'https://' ) . $_SERVER['SERVER_NAME'];
		}

		public static function parse_route( $route = null ) {
			global $bitphp;

			//BASE_PATH
			$_ROUTE['BASE_PATH'] = self::getBasePath();
			//Url
			$_ROUTE['URL'] = self::getUrl( $route );
			//APP_PATH
			$_ROUTE['APP_PATH'] = self::getAppPath( $_ROUTE['URL'] );
			//APP CONTROLLER
			$_ROUTE['APP_CONTROLLER'] = self::getAppController( $_ROUTE['URL'] );
			//APP ACCTION
			$_ROUTE['APP_ACCTION'] = self::getAppAction( $_ROUTE['URL'] );
			//SERVER NAME
			$_ROUTE['SERVER_NAME'] = self::getFullServerName();
			//PUBLIC_PATH_LINK
			$_ROUTE['PUBLIC'] = $_ROUTE['SERVER_NAME'] . $_ROUTE['BASE_PATH'] . '/public';
			//APP_LINK
			$_ROUTE['APP_LINK'] = $_ROUTE['SERVER_NAME'] . $_ROUTE['BASE_PATH'];

			if( $bitphp->config->property('hmvc') ) {
				$_ROUTE['APP_LINK'] .= '/' . ( empty($_ROUTE['URL'][0]) ? $bitphp->config->property('main_app') : $_ROUTE['URL'][0] );
			}

			return $_ROUTE;
		}
	}
