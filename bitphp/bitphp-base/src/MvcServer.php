<?php 
	
	namespace Bitphp\Base;

	use \Bitphp\Core\Globals;
	use \Bitphp\Base\Server;
	use \Bitphp\Base\MvcServer\Route;

	class MvcServer extends Server {

		private $controller;
		private $action;

		public function __construct() {
			parent::__construct();

			$route = Route::parse(Globals::get('request_uri'));
			# MVC aquí :v
			Globals::registre('uri_params', $route['params']);
			$this->controller = $route['controller'];
			$this->action = $route['action'];
		}

		/**
		 *	Implementacion del metodo abstracto run()
		 */
		public function run() {

			$file = Globals::get('base_path') . '/app/controllers/' . ucfirst($this->controller) . '.php';
			if(false === file_exists($file)){
				$message  = "Error al cargar el controlador '$this->controller.' ";
				$message .= "El archivo del controlador '$file' no existe";
				trigger_error($message);
				return false;
			}

			require $file;

			//$fullClassName = '\App\Controllers\\' . $this->controller;
			$controller = new $this->controller;

			# Si el controlador no tiene la accion indicada sale
			if(!method_exists($controller, $this->action)) {
				$message  = "La clase del controlador '$this->controller' ";
				$message .= "no contiene el metodo '$this->action'";
				trigger_error($message);
				return;
			}

			call_user_func(array($controller, $this->action));
		}
	}