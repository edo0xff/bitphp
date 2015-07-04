<?php

	namespace Bitphp\Core;

	use \Bitphp\Core\Config;
	use \Bitphp\Core\Globals;

	class Cache {

		private static function generateName($data) {
			$label = json_encode($data);
			$dir = Globals::get('base_path') . '/olimpus/cache/';
			return $dir . md5($label) . '.lock';
		}

		public static function isCached($data) {
			if(false === Config::param('cache'))
				return false;

			$file = self::generateName($data);
			$cachetime = Config::param('cache.time');

			if( null === $cachetime || !is_numeric($cachetime) )
				$cachetime = 300; //senconds

			if(file_exists($file)) {
				if((fileatime($file) + $cachetime) >= time()) {
					return file_get_contents($file);
				}

				unlink($file);
			}

			return false;
		}

		public static function save($data, $content) {
			if(false === Config::param('cache'))
				return false;
			
			$file = self::generateName($data);
			$writer = fopen($file, 'w');
			fwrite($writer, $content);
			fclose($writer);
		}
	}