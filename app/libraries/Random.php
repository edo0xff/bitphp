<?php

  class Random
  {
    /**
     * Creara una cadena de n numero de caracteres con ([A-Z])[[a-z]]([0-9]) y ([_])
     *
     * @param int $lenght *numero de caracteres aleatorios que se colocaran el la cadena*
     *
     * @return string     *cadena aleatoria de n numero de caracteres*
     */
    function string($length)
    {
      $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890123456789_';
      $out  = '';

      for ($i = 0;$i < $length; $i++) {
        $out .= $pool[rand(0, 72)];
      }
      return $out;
    }
    
  }
?>