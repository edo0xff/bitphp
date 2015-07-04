<?php

	use \Bitphp\Modules\Layout\Medusa;

	class Main {

		public function __construct() {
			$this->medusa = new Medusa();
		}

		public function __index() {
			$this->medusa
				 ->load('welcome')
				 ->draw();
		}
	}