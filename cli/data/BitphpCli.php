<?php namespace BitPHP\Cli;

	use \BitPHP\Cli\ConfigIgniter as Config;
	use \BitPHP\Cli\StandardLibrary as Standard;
	use \BitPHP\Cli\MvcIgniter as Mvc;
	use \BitPHP\Cli\HmvcIgniter as Hmvc;
	use \BitPHP\Cli\MicroIgniter as Micro;
	use \Bitphp\Cli\RestIgniter as Rest;

	class BitphpCli {

		public function __call( $called, array $args ) {
			Standard::output( "Error: invalid command $called.", 'FAILURE' );
			$this->suggestHelps();
		}

		private function notArguments() {
			Standard::output( "Error: this option requires an argument.",'FAILURE' );
			$this->suggestHelps();
		}

		private function suggestHelps() {
			Standard::output( 'Type: "php dummy help" for help','INFO' );
		}

		public function help() {
			$help = file_get_contents( 'data/help.txt' );
			Standard::output( $help );
		}

		public function create( $args ) {
			if( !isset( $args[2] ) ){ $this->notArguments(); return; }
			switch ( $args[2] ) {
				case 'config.json':
					$output_dir = isset( $args[3] ) ? $args[3] : null;
					Config::create( $output_dir );
					break;
				
				default:
					Standard::output("Error: invalid option to create.",'FAILURE');
					$this->suggestHelps();
					break;
			}
		}

		public function init( $args ) {
			$app_type = isset( $args[2] ) ? $args[2] : 'blank' ;
			switch ( $app_type ) {
				case 'blank':
					Standard::output("Attempt to init a blank app...",'INFO');
					Config::create();
					$index = file_get_contents( 'data/templates/blank/index.txt' );
					$file = fopen( '../index.php', 'w' );
					fwrite( $file, $index );
					fclose( $file );
					Standard::output("Blank app was created.",'SUCCESS');
					break;

				case 'mvc':
					$message  = "Attempt to initialize a mvc app...";
					Standard::output( $message );
					Mvc::init();
					break;

				case 'hmvc':
					$message  = "Attempt to initialize a hmvc app...";
					Standard::output( $message );
					Hmvc::init();
					break;

				case 'micro':
					$message = "Attempt to initialize a micro mvc app...";
					Standard::output( $message );
					Micro::init();
					break;

				case 'rest':
					$message = "Attempt to initialize a RESTful app...";
					Standard::output( $message );
					Rest::init();
					break;

				default:
					Standard::output("Error: uknow type aplication '$app_type'.",'FAILURE');
					break;
			}
		}
	}