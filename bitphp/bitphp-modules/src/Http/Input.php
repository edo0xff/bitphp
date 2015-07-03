<?php 

	namespace Bitphp\Modules\Http;

	use \Bitphp\Core\Globals;

	/**
	 *	Obtiene una entrada limpia de los metodos de entrada
	 */
	class Input {

		/**
		 *	Para ahorrar codigo tio
		 */
		private static function filter($index, $method, $filter) {
			$filter = $filter ? FILTER_SANITIZE_FULL_SPECIAL_CHARS : FILTER_DEFAULT;
   			return filter_input($method, $index, $filter);
		}

		/**
		 *	Obtiene la entrada limpia de los parametros de la url
		 */
		public static function url($index, $filter = true) {
			$parms = Globals::get('uri_params');

			if(is_numeric($index)) {
				if(isset($parms[$index])) {
					$result = $parms[$index];
				} else {
					return null;
				}
			} else {
				$index = array_search($index, $_BITPHP['URI_PARAMS']);
				$result = self::url($index + 1, $filter);
			}

			$filter = $filter ? FILTER_SANITIZE_FULL_SPECIAL_CHARS : FILTER_DEFAULT;
			return filter_var($result, $filter);
		}

		/**
		 *	Obtiene una entrada limpia de $_POST[$index]
		 *	el segundo parametro en false desactiva el filtro
		 */
		public static function post($index, $filter = true) {
			return self::filter($index, INPUT_POST, $filter);
   		}

   		/**
		 *	Obtiene una entrada limpia de $_GET[$index]
		 */
		public static function get($index, $filter = true) {
			return self::filter($index, INPUT_GET, $filter);
   		}

   		/**
   		 *	Obtiene una entrada limpia de $_COOKIE[$index]
   		 */
   		public static function cookie($index, $filter = true) {
   			return self::filter($index, INPUT_COOKIE, $filter);
   		}
	}