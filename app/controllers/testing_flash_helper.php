<?php \BitPHP\Load::helper('FlashMessages');

	class Testing_flash_helper extends \Helpers\FlashMessages {

		public function index() {
			\BitPHP\Load::view([
				'header',
				'flash_test',
				'footer'
			]);
		}

		public function show() {
			$type = \BitPHP\Input::url_param(0);
			$name = \BitPHP\Input::url_param(1);

			$name = $name ? $name : 'Extraño';

			switch ($type) {
				case 'info':
					$this->info('Mensaje informativo',"<b>$name</b> esto es un mensaje informativo.");
					return 1;
				case 'success':
					$this->success('¡Mensaje de éxito!',"<b>$name</b> este mensaje indica que una acción se realizo exitosamente.");
					return 1;
				case 'warning':
					$this->warning('¡Mesaje de alerta!',"<b>$name</b> este mensaje nos indica una advertencia D:");
					return 1;
				case 'danger':
					$this->danger('¡Mensaje de error!', "<b>$name</b> este mensaje indica un error :C");
					return 1;
				case 'normal':
					$this->normal('Mensaje normal', "<b>$name</b> este es un mensaje sin formato.");
					return 1;
			}
		}
	}
?>