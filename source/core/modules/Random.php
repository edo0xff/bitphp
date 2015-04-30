<?php

	/**
  	*	@author Eduardo B <ms7rbeta@gmail.com>
  	*/
	class Random
	{
		/**
		 * Creara una cadena de n numero de caracteres (se indican en el parametro) con ([A-Z])[[a-z]]([0-9]) y ([_])
		 *
		 * @param int $lenght numero de caracteres aleatorios que se colocaran el la cadena
		 * @return string
		 */
		public static function string( $length )
		{
			$pool    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ012345678901234567899_';
			$limit = (strlen($pool) - 1);
			$out = '';

			for ($i = 1;$i <= $length; $i++) {
				$out .= $pool[rand(0,$limit)];
			}

			return $out;
		}
	}
?>