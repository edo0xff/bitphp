<?php
  
  class Home {

    public function index() {
      \BitPHP\Load::view('default/welcome');
    }

    public function gen_error() {
    	\BitPHP\Load::view('bad_view');
    }
  }
  
?>