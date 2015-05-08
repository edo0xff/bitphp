<?php
	
	require('core/sys/bitphp_base/Error.php');

	use \BitPHP\Sys\Error as ErrorDebugger;
	
	/**
	 *	Coded by Eduardo B <ms7rbeta@gmail.com>
	 */
	class BitPHP {

		public $config = null;
		public $error = null;
		public $route = null;

		public function __construct() {

			$config_json = @file_get_contents( 'app/config.json' );
			if( $config_json === false ) {
				$_title =  'La aplicacion requiere de un archivo de configuración, el cual no pudimos encontrar.';
				require('core/views/config_maker.php');
				exit;
			}

			$this->config = json_decode( $config_json, true );
			$this->error = new ErrorDebugger( $this->getEnviromentProperty('debug') );
		}

		public function loadMvcServer() {

			require('core/sys/Mvc.php');
			return new \BitPHP\Apps\Mvc();
		}

		public function loadApiServer() {

			require('core/sys/Api.php');
			return new \BitPHP\Apps\Api();
		}

		public function loadMicroServer() {

			require('core/sys/MicroServer.php');
			return new \BitPHP\Apps\MicroServer();
		}

		public function configMaker() {
			$_title =  "Config maker";
			require('core/views/config_maker.php');
			exit;
		}

		public function getProperty( $property ) {

			if( !isset( $this->config[ $property ] ) ) {
				$_title =  "La aplicacion requiere de un parametro de configuración <b>$property</b>, el cual no pudimos encontrar.";
				require('core/views/config_maker.php');
				exit;
			} else {
				return $this->config[ $property ];
			}
		}

		public function getEnviromentProperty( $property ) {
			
			if( !isset( $this->config['enviroment'] ) ) {
				$_title =  "La aplicacion requiere de un parametro de configuración <b>enviroment</b>, el cual no pudimos encontrar.";
				require('core/views/config_maker.php');
				exit;
			}

			$enviroment = $this->config['enviroment'];

			if( !isset( $this->config[ $enviroment ][ $property ] ) ) {
				$_title =  "La aplicacion requiere de un parametro de configuración <b>$property</b>, el cual no pudimos encontrar.";
				require('core/views/config_maker.php');
				exit;
			} else {
				return $this->config[ $enviroment ][ $property ];
			}
		}
	}

	$bitphp = new BitPHP();