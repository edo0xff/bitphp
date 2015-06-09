<?php namespace BitPHP\Cli;

	class ConsoleColors {

		private static $linuxPallete = [
			  'gray' => '[1;30m'
			, 'red' => '[31m'
			, 'green' => '[32m'
			, 'yelllow' => '[33m'
			, 'blue' => '[34m'
			, 'purple' => '[35m'
			, 'cyan' => '[36m'
			, 'white' => '[37m'
			, 'bold_red' => '[1;31m'
			, 'bold_green' => '[1;32m'
			, 'bold_yellow' => '[1;33m'
			, 'bold_blue' => '[1;34m'
			, 'bold_purple' => '[1;35m'
			, 'bold_cyan' => '[1;49;36m'
			, 'bold_white' => '[1;37m'
			, 'back_red' => '[7;49;31m'
			, 'back_green' => '[7;49;92m'
			, 'back_white' => '[7;49;39m'
			, 'reset' => '[0m'
		];

		private static function color( $color ) {
			$sistem = substr(PHP_OS, 0, 3);
			$sistem = strtoupper( $sistem );

			if( $sistem == 'WIN' ) {
				return null;
			} else {
				$color = chr( 27 ) . self::$linuxPallete[ $color ];
			}

			return $color;
		}

		//\033[1;31mbold red text\033[0m\n
		public static function get( $color, $string ) {
			$string = self::color( $color ) . $string . self::color('reset');
			return $string;
		}
	}