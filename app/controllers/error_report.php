<?php
  /*
   *	Si no deseas esta funcionalidad debes poner
   *	CRYPTED_ISSUES_REPORT en False (confing.php linea 54),
   *	despues de ello puedes eliminar este archivo.
   */
  class Error_report {

    public function index() {
        $msg = \BitPHP\Input::post('err_msg');
        
        if($msg) {
	  $sc = \BitPHP\Load::library('SpiderCrypt');
	  
	  $msg = $sc->sDecrypt($msg, \BitPHP\Config::CRYPT_KEY);
	  $to = \BitPHP\Config::ADMIN_EMAIL;
	  $subject = '¡Reporte de error en tu sitio!';
	  $body = "Mensaje de error: \n\n$msg";
	  $headers = "From: noreply@bitphp.com\n";
	  $headers .= 'Reply-To: noreply@bitphp.com';

	  mail($to, $subject, $body, $headers);
	  echo '¡Enviado!';
        }
    }

  }

?>