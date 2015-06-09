<?php namespace BitPHP\Cli\Igniters;
	
	use \BitPHP\Cli\StandardLibrary as Standard;
	use \BitPHP\Cli\FileWriter as File;
	use \BitPHP\Cli\Igniters\Config;
	use \BitPHP\Cli\Interfaces\Igniter;

	class Hmvc implements Igniter {
		private static function makeDirs() {
			Standard::output("Creating HMVC directories...");
			//app
			if( !is_dir( '../app/MyApp1/' ) ) {
				mkdir('../app/MyApp1/');
			}
			// controllers
			if( !is_dir( '../app/MyApp1/controllers/' ) ) {
				mkdir('../app/MyApp1/controllers/');
			}
			//views
			if ( !is_dir( '../app/MyApp1/views/' ) ) {
				mkdir('../app/MyApp1/views/');
			}
			//models
			if ( !is_dir( '../app/MyApp1/models/' ) ) {
				mkdir('../app/MyApp1/models/');
			}
		}

		private static function makeIndex() {
			$index = file_get_contents( 'data/templates/mvc/index.txt' );
			Standard::output("Setting index.php...");
			
			File::write( '../index.php', $index );
			Standard::output("index.php was created.",'INFO');
		}

		private static function makeTemplate() {
			Standard::output("Creating a HMVC Template...");
			
			$controller = file_get_contents( 'data/templates/mvc/controller.txt' );
			File::write( '../app/MyApp1/controllers/say.php', $controller );

			$view = file_get_contents( 'data/templates/view.tmpl.txt' );
			File::write( '../app/MyApp1/views/welcome.tmpl.php', $view );
		}

		public static function init() {
			Config::create(null,'data/templates/hmvc/config.json');
			self::makeDirs();
			self::makeIndex();
			self::makeTemplate();

			Standard::output( "Hmvc aplication was created.", 'SUCCESS' );
			Standard::output( "You can go to http://your.domain.com/MyApp1/say/hello", 'FINAL' );
		}
	}