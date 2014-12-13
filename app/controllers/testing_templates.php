<?php
	
	class Testing_templates {

		public function index() {
			echo '<meta charset="utf-8">';

			$params = [
				'nombre'  => 'Juan',
				'edad'    => 15,
				'frutas'  => [
					'manzana',
					'platano',
					'mango',
					'sandia'
				]
			];

			$start = microtime();
			\BitPHP\Load::template('test_template', $params);
			$finish = microtime();
			echo 'Template render in: ', ($finish - $start), ' ms';

			$start = microtime();
			\BitPHP\Load::view('test_without_template', $params);
			$finish = microtime();
			echo 'View load in: ', ($finish - $start), ' ms';
		}
	}

?>