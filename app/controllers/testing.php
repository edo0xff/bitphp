<?php

	class Testing {

		public function index() {
			\BitPHP\Load::template('test',
				[
					'title' => 'Template test',
					'nombre' => 'Juan',
					'edad' => 15
				]
			);
		}
	}
?>