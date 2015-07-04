<?php 

	namespace Bitphp\Core;

	$_BITPHP_CONFIG = array();

	/**
	 *	Proporciona los metodos para leer el archivo de configuracion de
	 *	la aplicacion
	 */
	class Config {

		/**
		 *	verifica y carga el archivo
		 *	de configuracion de la aplicacion
		 */
		public static function load($file) {
			global $_BITPHP_CONFIG;

			if( file_exists($file) ) {
				$content = file_get_contents($file);
				$_BITPHP_CONFIG = json_decode($content, true);
			}
		}

		/**
		 *	Lee un parametro de configuracion
		 */
		public static function param($index) {
			global $_BITPHP_CONFIG;
			return isset($_BITPHP_CONFIG[$index]) ? $_BITPHP_CONFIG[$index] : null;
		}

		public static function all() {
			global $_BITPHP_CONFIG;
			return $_BITPHP_CONFIG;
		}
	}