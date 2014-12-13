<?php

	class Testing {

		public function index() {
			echo '<meta charset="utf-8">';

			$start = microtime();

			\BitPHP\Load::template('test_template',
				[
					'title' => 'Template test',
					'nombre' => 'José',
					'edad' => 78
				]
			);

			$finish = microtime();

			echo '<p>Template render in: ', ($finish - $start), ' ms <p>';

			$start = microtime();

			\BitPHP\Load::view('test',
				[
					'title' => 'Template test',
					'nombre' => 'Juan',
					'edad' => 15
				]
			);

			$finish = microtime();

			echo '<p>View load in: ', ($finish - $start), ' ms <p>';

		}
	}
?>