<?php namespace BitPHP\Cli;

	use \BitPHP\Cli\StandardLibrary as Standard;

	class DirHashing {
		public static function scan($dir) {
			$result = array();
			
			Standard::output("Scaning $dir...");

			usleep(50000);

			foreach (scandir($dir) as $read) {
				if($read == '.' || $read == '..' || $read == 'bittrash' || $read == 'log')
					continue;

				$file = $dir . '/' . $read;

				if(is_dir($file)) {
					$result = array_merge($result, self::scan($file));
					continue;
				}

				$result[$file] = md5(file_get_contents($file));
			}

			return $result;
		}
	}