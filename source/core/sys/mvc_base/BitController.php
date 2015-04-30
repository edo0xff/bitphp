<?php

	use \BitPHP\Sys\Error as ErrorDebugger;

	class BitController {

		public $load;
		public $input;
		public $error;

		public function __construct() {

			global $bitphp;

			$this->load  = new \BitPHP\Mvc\Load();
			$this->input = new \BitPHP\Mvc\Input();
			$this->error = $bitphp->error;
		}
	}
?>