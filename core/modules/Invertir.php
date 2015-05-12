<?php

	class Invertir {

		public function __construct( $algo ) {
			echo "Hola $algo<br>";
		}

		public function cadena( $s ) {
			$i = strlen( $s ) - 1;
			$r = '';

			for( $j = $i; $j >= 0; $j-- ) {
				$r .= $s[$j];
			}

			return $r;
		}
	}