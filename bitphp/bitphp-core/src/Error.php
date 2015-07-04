<?php 

	namespace Bitphp\Core;
	
	use \Exception;
	use \Bitphp\Core\Globals;

	class Error {

		private $log_file;
		private $errors;
		public $debug;

		public function __construct() {

			#No se muestran, bitphp se encarga de ellos :3
			ini_set('display_errors', 0);
    		error_reporting(E_ALL);
    		#se definen las funciones para el manejo de errores
    		set_error_handler(array($this, 'globalErrorHandler'));
    		register_shutdown_function(array($this, 'fatalErrorHandler'));

    		#debug de errores
			$debug = Config::param('debug');
			$this->debug = ( null === $debug ) ? true : $debug;

    		$this->log_file = Globals::get('base_path') . '/olimpus/log/errors.log';
    		$this->errors = array();
		}
		
		/**
		 *	Añade un registro de error al archivo de errores
		 *	en formato JSON, retorna id del error si el registro
		 *	fue satisfactorioo false si este falló
		 */
		private function log($code, $message, $file, $line, $trace) {
			$date = date('l jS \of F Y h:i:s A');
			$identifier =  md5($date . rand(0, 9999));

			$log = [
				  'date' => $date
				, 'message' => $message
				, 'id' => $identifier
				, 'trace' => $trace
				, 'code' => $code
				, 'file' => $file
				, 'line' => $line
			];

			$log = json_encode($log) . PHP_EOL;

			$done = @error_log($log, 3, $this->log_file);
			return $done ? $identifier : false;
		}

		/**
		 *	Bitphp gestiona todos los errores de php
		 */
		public function globalErrorHandler($code, $message, $file, $line) {
			$exception = new Exception();
			$trace = $exception->getTrace();

			$identifier = $this->log($code, $message, $file, $line, $trace);
			$this->errors[] = [
				  'code' => $code
				, 'message' => $message
				, 'file' => $file
				, 'line' => $line
				, 'identifier' => $identifier
				, 'trace' => $trace
			];
		}

		public function fatalErrorHandler() {		
			$error = error_get_last();
			
			if(null !== $error) {
				 $this->globalErrorHandler(
				 	  E_ERROR
				 	, $error['message']
				 	, $error['file']
				 	, $error['line']
				 );
			}

			if (!empty($this->errors)) {
				#Si esta habilitado el debug lo muestra y si no manda 404
				if($this->debug) {
					$errors = $this->errors;
					require Globals::get('base_path') . '/olimpus/views/error_message.php';
				} else {
					echo "404 Not Found";
				}
			}
		}
	}