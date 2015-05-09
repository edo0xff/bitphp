<?php namespace BitPHP\Cli;

	use \BitPHP\Cli\ConsoleColors as Color;

	class StandardLibrary {

		public $promt = 'bit ~ ';

		public static function output( $string, $type = null, $new_line = "\n" ) {
			
			$color = '';
			switch ( $type ) {
				case 'FAILURE':
					$color = 'back_red';
					break;

				case 'INFO':
					$color = 'bold_cyan';
					break;

				case 'SUCCESS':
					$color = 'bold_green';
					break;

				case 'EMPASIS':
					$color = 'back_green';
					break;

				case 'WARNING':
					$color = 'bold_yellow';
					break;

				case 'FINAL':
					$color = 'back_white';
					break;

				default:
					$color = 'bold_white';
					break; 
			}

			//error_log(  );
			echo Color::get( $color,$string . $new_line );
		}

		public static function input() {
			return trim( fgets( STDIN ) );
		}
	}