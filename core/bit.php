<?php
	
	require 'core/sys/bitphp_base/DataBase.php';
	require 'core/sys/bitphp_base/Error.php';
	require 'core/sys/bitphp_base/ConfigReader.php';

	use \BitPHP\Sys\Error as ErrorDebugger;
	use \BitPHP\Sys\ConfigReader as Config;
	use \BitPHP\Apps\MvcServer;
	use \BitPHP\Apps\ApiServer;
	use \BitPHP\Apps\MicroServer;
	
	/**
	 *	Coded by Eduardo B <ms7rbeta@gmail.com>
	 */
	class BitPHP {

		public $config = null;
		public $error = null;
		public $route = null;

		public function __construct() {
			$this->config = new Config();
			$this->error = new ErrorDebugger( $this->config->environmentProperty('debug') );
		}

		public function loadMvcServer() {
			require('core/sys/MvcServer.php');
			return new MvcServer();
		}

		public function loadMicroServer() {
			require('core/sys/MicroServer.php');
			return new MicroServer();
		}

		public function loadApiServer() {
			require('core/sys/ApiServer.php');
			return new ApiServer();
		}
	}

	$bitphp = new BitPHP();