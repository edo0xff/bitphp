<?php
	
	namespace Bitphp\Core;

	$_BITPHP = array();

	class Globals {

		public static function registre($var, $val = null) {
			global $_BITPHP;

			if(is_array($var)) {
				foreach ($var as $name => $value) {
					self::registre($name, $value);
				}
				return;
			}

			$_BITPHP[$var] = $val;
		}

		public static function get($var) {
			global $_BITPHP;
			return isset($_BITPHP[$var]) ? $_BITPHP[$var] : null;
		}

		public static function all() {
			global $_BITPHP;
			return $_BITPHP;
		}
	}