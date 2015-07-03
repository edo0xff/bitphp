<?php 
	
	namespace Bitphp\Modules\Layout;

	use \Bitphp\Core\Globals;

	/**
	 *	Modulo para el manejo de vistas
	 */
	class View {

		protected $loaded;
		protected $variables;
		protected $mime;
		public $source;

		/**
		 *	Limpia todo para poder volver a usarlo con otras vistas
		 */
		protected function clean() {
			$this->source = '';
			$this->loaded = false;
			$this->variables = array();
		}

		public function __construct() {
			$this->clean();
			$this->mime = '.php';
		}

		/**
		 *	Lee y carga el contenido de una vista a $this->source
		 *	solo si existe la vista
		 */
		public function load($name) {

			if(is_array($name)) {
				foreach ($name as $other) {
					$this->load($other);
				}

				return $this;
			}

			$file = Globals::get('base_path') . "/app/views/$name" . $this->mime;
			if(false === file_exists($file)) {
				$message  = "No se pudo cargar las vista '$name.' ";
				$message .= "El fichero '$file' no existe";
				trigger_error($message);
				return false;
			}

			$this->loaded = true;
			$this->source .= file_get_contents($file);
			return $this;
		}

		/**
		 *	Setea las variables qué se le pasaran a la vista
		 */
		public function with($vars) {
			$this->variables = $vars;
			return $this;
		}

		/**
		 * Imprime la vista
		 */
		public function draw() {
			$_BITPHP = Globals::all();
			
			if(!$this->loaded) {
				$message  = 'No se pudo mostrar la(s) vista(s) ';
				$message .= 'ya que no se han cargado ninguna';
				trigger_error($message);
				return;
			}

			extract($this->variables);
			eval("?> $this->source <?php ");
			$this->clean();
		}

		/**
		 * Carga la vista pero no la muestra, la retorna en un string
		 */
		public function read() {
			if(!$this->loaded) {
				$message  = 'No se pudo leer la(s) vista(s) ';
				$message .= 'ya que no se han cargado ninguna';
				trigger_error($message);
				return;
			}

			ob_start();
			$this->draw();
			$this->clean();
			return ob_get_clean();
		}

		/**
		 *	Metodo estatico para cargar, setear variables y mostar
		 *	la vista en un solo paso
		 */
		public static function quick($name, $vars = array()) {
			$loader = new View();
			$loader->load($name)->with($vars)->draw();
			$loader = null;
		}
	}