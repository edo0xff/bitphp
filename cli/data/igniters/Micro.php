<?php namespace BitPHP\Cli\Igniters;

	use \BitPHP\Cli\StandardLibrary as Standard;
	use \BitPHP\Cli\FileWriter as File;
	use \BitPHP\Cli\Igniters\Config;
	use \BitPHP\Cli\Interfaces\Igniter;

	class Micro implements Igniter {
		
		private static function makeDirs() {
			Standard::output("Creating Micro MVC directories...");
			//views
			if ( !is_dir( '../app/views/' ) ) {
				mkdir('../app/views/');
			}
			//models
			if ( !is_dir( '../app/models/' ) ) {
				mkdir('../app/models/');
			}
		}

		private static function makeIndex() {
			$index = file_get_contents( 'data/templates/micro/index.txt' );
			Standard::output("Setting index.php...");
			
			File::write( '../index.php', $index );
			Standard::output("index.php was created.",'INFO');
		}

		private static function makeTemplate() {
			Standard::output("Creating a Micro MVC Template...");

			$view = file_get_contents( 'data/templates/view.tmpl.txt' );
			File::write( '../app/views/welcome.tmpl.php', $view );
		}

		public static function init() {
			Config::create( null, 'data/templates/micro/config.json' );
			self::makeDirs();
			self::makeIndex();
			self::makeTemplate();

			Standard::output( "Micro MVC aplication was created.", 'SUCCESS' );
			Standard::output( "You can go to http://your.domain.com/say/hello", 'FINAL' );
		}
	}