<?php
  /**
    *	 ____        _     _ _____       ____
    *	/ ___| _ __ (_) __| |___ / _ __ / ___|_ __ _   _ _ __
    *	\___ \| '_ \| |/ _` | |_ \| '__| |   | '__| | | | '_ \
    *	 ___) | |_) | | (_| |___) | |  | |___| |  | |_| | |_) |
    *	|____/| .__/|_|\__,_|____/|_|   \____|_|   \__, | .__/
    *	      |_|                                  |___/|_|
    * ========================================================
    *	Algoritmo de Cryptografía simétrica
    *
    *	@autor Eduardo B. <ms7rbeta@gmail.com>
    *
    *	@version	1.0
    *
    *	@license	GNU-GPL v3
    *
    *	@site <root404.com/eduardo>
    *
    */
  class SpiderCrypt {
    /**
     *	SpiderCryp()
     *
     *	Devuelve una cadena cifrada.
     *
     *	@param String $string *cadena que se va a cifrar*
     *
     *	@param String $key    *clave que se usara para el cifrado*
     *
     *	@return String
     */
    function sCrypt($string, $key) {
      $str_limit = strlen($string) - 1;
      $key_limit = strlen($key) - 1;
      $output = "";
      $hexadecimal = "";
      $j = 0;

      for($i = 0; $i <= $str_limit; $i++) {
	if($j >= $key_limit) { $j = 0; }
	$asc_result = ord($string[$i]) + ord($key[$j]);
	if($asc_result > 255) { $asc_result = 0; }
	$hexadecimal = dechex($asc_result);
	$output .= $hexadecimal;
	$j++;
      }

      return $output;
    } //spiderCryp ends

    /**
     *	spiderDecryp()
     *
     *	Devuelve una cadena en texto plano (siempre y cuando el texto original allá sido
     *	cifrado con el algoritmo spid3r y de igual manera la clave sea la misma que con la que
     *	se encripto :p)
     *
     *	@param String $string *cadena que se va a cifrar*
     *
     *	@param String $key    *clave que se usara para el cifrado*
     *
     *	@return String
     */
    function sDecrypt($string, $key) {
      $str_limit = strlen($string) - 1;
      $key_limit = strlen($key) - 1;
      $output = "";
      $char = "";
      $j = 0;

      for($i = 0; $i <= $str_limit; $i += 2) {
	if($j >= $key_limit) { $j = 0; }
	$asc_result = hexdec($string[$i].$string[$i + 1]) - ord($key[$j]);
	if($asc_result < 0) { $asc_result = 255; }
	$chr = chr($asc_result);
	$output .= $chr;
	$j++;
      }
      return $output;
    }//spiderDecryp ends

  }
?>