<?php namespace BitPHP;
	
	use \BitPHP\Config;

	class Route {

		private static function validate_app($app) {
			if( !is_dir( $app ) ) {
				$d = 'Oops! hubo un problema al ejecutar la aplicacion.';
				$e = 'La aplicacion <b>/'. $app .'/</b> no existe.';
				Error::trace($d, $e, false);
			}

			return $app;
		}

		public static function parse_route() {
			return empty($_GET['_route']) ? array() : explode('/', $_GET['_route']) ;
		}

		public static function app_link() {
			global $_URL;

			$link = ( empty( $_SERVER['HTTPS'] ) ? 'http://' : 'https://' ) . $_SERVER['SERVER_NAME'];

			if( Config::ENABLE_HMVC && ( Config::DEV || Config::ENABLE_PRO_MULTI_APP ) ) {
				$link .= '/' . ( empty($_URL[0]) ? Config::MAIN_APP : $_URL[0] );
			}

			return $link;
		}

		public static function app_path( $route ) {
			$path = 'app';

			if( Config::ENABLE_HMVC ) {
				if( Config::DEV || Config::ENABLE_PRO_MULTI_APP ) {
					$path .= '/' . ( empty($route[0]) ? Config::MAIN_APP : $route[0] );
				} else {
					$path .= '/' . Config::$ON_PRO['APP_RUNNING'];
				}
			}

			return self::validate_app( $path );
		}

		public static function get_controller( $route ) {
			$i = ( (Config::DEV || Config::ENABLE_PRO_MULTI_APP) && Config::ENABLE_HMVC ) ? 1 : 0 ;
			return empty( $route[$i] ) ? Config::MAIN_CONTROLLER : $route[$i] ;
		}

		public static function get_method( $route ) {
			$i = ( (Config::DEV || Config::ENABLE_PRO_MULTI_APP) && Config::ENABLE_HMVC ) ? 2 : 1 ;
			return empty( $route[$i] ) ? Config::MAIN_ACTION : $route[$i] ;
		}
	}
?>