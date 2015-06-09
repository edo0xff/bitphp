<?php namespace BitPHP\Cli\Igniters;

	use \BitPHP\Cli\StandardLibrary as Standard;
	use \BitPHP\Cli\FileWriter as File;
	use \BitPHP\Cli\Igniters\Config;
	use \BitPHP\Cli\Interfaces\Igniter;

	class Mvc implements Igniter {
		private static function makeDirs() {
			Standard::output("Creating MVC directories...");
			// controllers
			if( !is_dir( '../app/controllers/' ) ) {
				mkdir('../app/controllers/');
			}
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
			$index = file_get_contents( 'data/templates/mvc/index.txt' );
			Standard::output("Setting index.php...");
			
			File::write( '../index.php', $index );
			Standard::output("index.php was created.",'INFO');
		}

		private static function makeTemplate() {
			Standard::output("Creating a MVC Template...");
			
			$controller = file_get_contents( 'data/templates/mvc/controller.txt' );
			File::write( '../app/controllers/say.php', $controller );

			$view = file_get_contents( 'data/templates/view.tmpl.txt' );
			File::write( '../app/views/welcome.tmpl.php', $view );
		}

		public static function init() {

			Config::create();
			self::makeDirs();
			self::makeIndex();
			self::makeTemplate();
			
			Standard::output( "Mvc aplication was created.", 'SUCCESS' );
			Standard::output( "You can go to http://localhost/say/hello", 'FINAL' );
		}
	}