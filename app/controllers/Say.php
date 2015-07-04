<?php
	
	use \Bitphp\Modules\Layout\Medusa;
	use \Bitphp\Modules\Http\Input;

	class Say {

		public function __construct() {
			$this->medusa = new Medusa();
		}

		public function hello() {
			$this->medusa
				 ->load('hello')
				 ->with([
				 	'name' => Input::url(0)
				 ])
				 ->draw();
		}
	}