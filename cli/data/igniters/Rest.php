<?php namespace BitPHP\Cli\Igniters;

	use \BitPHP\Cli\StandardLibrary as Standard;
	use \BitPHP\Cli\FileWriter as File;
	use \BitPHP\Cli\Igniters\Config;
	use \BitPHP\Cli\Interfaces\Igniter;

	class Rest implements Igniter {

		private static function makeIndex() {
			$index = file_get_contents( 'data/templates/rest/index.txt' );
			Standard::output("Setting index.php...");
			
			File::write( '../index.php', $index );
			Standard::output("index.php was created.",'INFO');
		}

		public static function init() {
			Config::create( null, 'data/templates/micro/config.json' );
			self::makeIndex();

			Standard::output( "RESTful aplication was created.", 'SUCCESS' );
			Standard::output( "You can go to http://localhost/api/v1/hello", 'FINAL' );
		}
	}