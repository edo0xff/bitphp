<?php

	namespace Bitphp\Cli;

	class Dummy {

		public static function run() {
			var_dump($_SERVER['argv']);
		}
	}