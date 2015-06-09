<?php

	use \BitPHP\Mvc\Load;
	use \BitPHP\Mvc\Input;

	class BitController {

		public $load;
		public $input;
		public $error;

		public function __construct() {

			global $bitphp;

			$this->load  = new Load();
			$this->input = new Input();
			$this->error = $bitphp->error;
			$this->config = $bitphp->config;
		}
	}