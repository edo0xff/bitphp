<?php \BitPHP\Load::helper('FlashMessages');

	class Testing_flash_helper extends \Helpers\FlashMessages {

		public function index() {
			\BitPHP\Load::view('header');
			//Aqui muestra la alerta
			$this->help();

			\BitPHP\Load::view('footer');
		}
	}
?>