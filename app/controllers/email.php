<?php

  class Email {

    public function index() {
      header('Location: http://'.$_SERVER['SERVER_NAME'].'/bit');
    }

    public function submit() {
      $name  = \BitPHP\Input::post('name');
      $email = \BitPHP\Input::email('POST','email');
      $msg   = \BitPHP\Input::post('msg');
      $type  = \BitPHP\Input::post('type');
      $errors = '';
      
      if(!$name) {
	$errors .= '- name is not set!<br>';
      }

      if(!$email) {
	$errors .= '- email is not set or is invalid!';
      }

      if(!$msg) {
	$errors .= '- you need type any message!';
      }

      if($errors) {
	echo '<div class="alert alert-danger"><b>Error</b><br>', $errors, '</div>';
      } else {
	$to = 'contacto@root404.com';
	$email_subject = '[BitPHP] Mensaje de:  '.$name;

	$email_body =  "$type\n";
	$email_body .= "+++++++++++\n\n";
	$email_body .= " Nombre: $name\n\n";
	$email_body .= " Correo: $email\n\n";
	$email_body .= " Mensaje:\n\n $msg\n\n+++++++++++";

	$headers = "From: bitphp@root404.com\n"; //El mensaje sera generado desde esta direccion
	$headers .= "Reply-To: $email";
	
	mail($to,$email_subject,$email_body,$headers);
	
	echo '<div class="alert alert-success"><b>Successful</b> message send, thanks for contact!</div>';
	echo '<script>(function(){$("#form-name").val("");$("#form-email").val("");$("#form-msg").val("");})()</script>';
      }
    }

  }

?>