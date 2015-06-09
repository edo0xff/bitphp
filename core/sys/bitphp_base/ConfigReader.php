<?php namespace BitPHP\Sys;

	class ConfigReader {

		public $data;
		
		private function loadConfigView( $_message = null ) {
			require 'core/views/sys_header.php';
			require 'core/views/config.php';
			require 'core/views/sys_footer.php';
			exit;
		}

		private function propertyNotFound($property) {
			$_message =  'La aplicacion requiere de un parametro de configuración: ';
			$_message .= "<i>$property</i>, el cual no pudimos encontrar. Trata creando ";
			$_message .= 'nuevamente el archivo de configuración.';
			$this->loadConfigView($_message);
		}

		public function __construct() {
			$config_json = @file_get_contents( 'app/config.json' );
			if( $config_json === false ) {
				$_message  = 'No se encontro el archivo de configuracion <i>config.json</i>, ';
				$_message .= 'el cual debe situarse en la carpeta <i>app/</i> por favor crea dicho archivo, ';
				$_message .= 'es necesario.';
				$this->loadConfigView($_message);
				exit;
			}

			$this->data = json_decode( $config_json, true );
		}

		public function maker() {
			$this->loadConfigView();
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
				$this->propertyNotFound($property);
				exit;
			} else {
				return $this->data[ $enviroment ][ $property ];
			}
		}
	}
