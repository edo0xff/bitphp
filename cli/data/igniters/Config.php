<?php namespace BitPHP\Cli\Igniters;

	use \BitPHP\Cli\FileWriter as File;
	use \BitPHP\Cli\StandardLibrary as Standard;

	class Config {
		private static function readConfigValue( $config, $recursive = null ) {
			foreach ($config as $key => $value) {
				if( !is_array( $value ) ) {
					$default = $value;
					Standard::output("\t$key($default): ",null,false);
					$value = Standard::input();
					$value = $value != '' ? $value : $default;
					$config[$key] = $value;
				} else {
					if( !empty( $value ) ) { 
						Standard::output("\t[$recursive$key config]\n",'INFO',false);
						$value = self::readConfigValue( $value, $key.'.' );
					}
					$config[$key] = $value;
				}
			}
			return $config;
		}

		public static function create( $output_dir = null, $template = 'data/templates/config.json' ) {

			$message = "Do you want to create config.json now? (yes/no):";
			Standard::output( $message, 'EMPASIS', false );

			$input = Standard::input();
			if( $input == 'n' || $input == 'no' ) {
				return;
			}

			$output_dir = $output_dir != null ? $output_dir : '../app/' ;

			if( !is_dir( $output_dir ) ) {
				Standard::output("Error: invalid output directory '$output_dir'",'FAILURE');
				return;
			}

			$message =  "Set config.json, press enter to default values.\n";
			$message .= "For more info visit: ";
			$message .= "http://bitphp.root404.com/docs/getstarted.html#el-archivo-de-configuracion\n";

			Standard::output( $message, 'INFO' );

			$json = file_get_contents( $template );
			$config = json_decode( $json, true );
			$config = self::readConfigValue( $config );

			Standard::output("Generating config.json...");

			$json = json_encode( $config, JSON_PRETTY_PRINT );
			File::write( $output_dir . 'config.json', $json );
			
			Standard::output("config.json was created!",'SUCCESS');
		}
	}