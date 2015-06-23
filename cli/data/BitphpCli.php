<?php namespace BitPHP\Cli;

	require 'data/ConsoleColors.php';
	require 'data/StandardLibrary.php';
	require 'data/FileWriter.php';
	require 'data/igniters/Igniter.php';
	require 'data/igniters/Rest.php';
	require 'data/igniters/Micro.php';
	require 'data/igniters/Hmvc.php';
	require 'data/igniters/Mvc.php';
	require 'data/igniters/Config.php';
	require 'data/igniters/RemoveIgniter.php';
	require 'data/igniters/Update.php';
	require 'data/igniters/Socket.php';
	require 'data/igniters/ErrorChecker.php';
	require 'data/igniters/TemplateCompiler.php';

	use \BitPHP\Cli\Igniters\Config;
	use \BitPHP\Cli\StandardLibrary as Standard;
	use \BitPHP\Cli\Igniters\Mvc;
	use \BitPHP\Cli\Igniters\Hmvc;
	use \BitPHP\Cli\Igniters\Micro;
	use \Bitphp\Cli\Igniters\Rest;
	use \BitPHP\Cli\Igniters\Update;
	use \BitPHP\Cli\Igniters\Socket;
	use \BitPHP\Cli\Igniters\ErrorChecker as Error;
	use \Bitphp\Cli\Igniters\TemplateCompiler as Compiler;
	use \BitPHP\Cli\RemoveIgniter as Remove;

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

		public function make() {
			Compiler::init();
		}

		public function help() {
			$help = file_get_contents( 'data/help.txt' );
			Standard::output( $help );
		}

		public function version() {
			$data = json_decode(file_get_contents('data/update.json'), true);
			Standard::output('CLI  version: dummy 1.2');
			Standard::output('Core version: ' . $data['code_name']);
		}

		public function remove() {
			Standard::output( 'Are you sure? (yes/no):' , 'EMPASIS', false );
			$confirm = Standard::input();
			if( $confirm == 'no' || $confirm == 'n' ) { return; }

			Standard::output( 'Seriusly??? (yes/no):','EMPASIS', false );
			$confirm = Standard::input();
			if( $confirm == 'no' || $confirm == 'n' ) { return; }

			Remove::init();
		}

		public function restore() {
			Remove::restore();
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

		public function error( $args ) {
			if( !isset( $args[2] ) ){ $this->notArguments(); return; }

			switch ($args[2]) {
				case 'dump':
					Error::dump();
					break;

				case 'all':
					Error::all();
					break;
				
				default:
					Standard::output("Cheking for error " . $args[2]);
					Error::check($args[2]);
					break;
			}
		}

		public function update() {
			Update::init();
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

				case 'socket':
					$message = "Attempt to initialize a Socket server...";
					Standard::output( $message );
					Socket::init();
					break;

				default:
					Standard::output("Error: uknow type aplication '$app_type'.",'FAILURE');
					break;
			}
		}
	}