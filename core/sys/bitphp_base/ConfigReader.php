<?php namespace BitPHP\Sys;

	class ConfigReader {

		public $data;
		
		private function propertyNotFound( $property ) {
			$_title =  "La aplicacion requiere de un parametro de configuración <b>$property</b>, el cual no pudimos encontrar.";
			require('core/views/config_maker.php');
			exit;
		}

		public function __construct() {
			$config_json = @file_get_contents( 'app/config.json' );
			if( $config_json === false ) {
				throw new Exception("Error Processing Request", 1);
			}

			$this->data = json_decode( $config_json, true );
		}

		public function maker() {
			$_title =  "Config maker";
			require('core/views/config_maker.php');
		}

		public function property( $index ) {
			if( !isset( $this->data[ $index ] ) ) {
				$this->propertyNotFound( $index );
			} else {
				return $this->data[ $index ];
			}
		}

		public function environmentProperty( $property ) {
			if( !isset( $this->data['enviroment'] ) ) {
				$this->propertyNotFound( 'enviroment' );
			}

			$enviroment = $this->data['enviroment'];

			if( !isset( $this->data[ $enviroment ][ $property ] ) ) {
				$_title =  "La aplicacion requiere de un parametro de configuración <b>$property</b>, el cual no pudimos encontrar.";
				require('core/views/config_maker.php');
				exit;
			} else {
				return $this->data[ $enviroment ][ $property ];
			}
		}
	}