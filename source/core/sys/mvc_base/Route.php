<?php namespace BitPHP\Mvc;

	class Route {

		private static function validate_app( $app ) {
			global $bitphp;

			if( !is_dir( $app ) ) {
				$d = 'Oops! hubo un problema al ejecutar la aplicacion.';
				$e = 'La carpeta de la aplicacion <b>/'. $app .'/</b> no existe.';
				$bitphp->error->trace($d, $e, false);
			}

			return $app;
		}

		public static function parse_route( $route = null ) {
			global $bitphp;

			//BASE_PATH
			$path = $bitphp->getEnviromentProperty('base_path');
			$len = strlen( $path ) - 1;
      		$path = ( $path[ $len ] == '/' ) ? substr( $path, 0, $len) : $path ;
      		$_ROUTE['BASE_PATH'] = $path;

			//String and URL array
			if ( !$route ) {
				$_ROUTE['URL'] =  empty($_GET['_route']) ? array() : explode('/', $_GET['_route']);
			} else {
				$_ROUTE['URL'] = explode('/', $route);
			}

			//APP_PATH
			$_ROUTE['APP_PATH'] = 'app';

			if( $bitphp->getProperty('hmvc') ) {
				$_ROUTE['APP_PATH'] .= '/' . ( empty( $_ROUTE['URL'][0] ) ? $bitphp->getProperty('main_app') : $_ROUTE['URL'][0] );
			}

			self::validate_app( $_ROUTE['APP_PATH'] );

			//APP CONTROLLER
			$i = ( $bitphp->getProperty('hmvc') ) ? 1 : 0 ;
			$_ROUTE['APP_CONTROLLER'] = empty( $_ROUTE['URL'][$i] ) ? $bitphp->getProperty('main_controller') : $_ROUTE['URL'][$i];

			//APP ACCTION
			$i = ( $bitphp->getProperty('hmvc') ) ? 2 : 1 ;
			$_ROUTE['APP_ACCTION'] = empty( $_ROUTE['URL'][$i] ) ? $bitphp->getProperty('main_action') : $_ROUTE['URL'][$i];

			//SERVER NAME
			$_ROUTE['SERVER_NAME'] = ( empty( $_SERVER['HTTPS'] ) ? 'http://' : 'https://' ) . $_SERVER['SERVER_NAME'];

			//APP_LINK
			$_ROUTE['APP_LINK'] = $_ROUTE['SERVER_NAME'] . $_ROUTE['BASE_PATH'];

			if( $bitphp->getProperty('hmvc') ) {
				$_ROUTE['APP_LINK'] .= '/' . ( empty($_ROUTE['URL'][0]) ? $bitphp->getProperty('main_app') : $_ROUTE['URL'][0] );
			}

			//PUBLIC_PATH_LINK
			$_ROUTE['PUBLIC'] = $_ROUTE['SERVER_NAME'] . $_ROUTE['BASE_PATH'] . '/public';

			return $_ROUTE;
		}
	}
?>