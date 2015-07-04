<?php 
	
	namespace Bitphp\Modules\Layout;

	use \Bitphp\Core\Globals;
	use \Bitphp\Core\Config;
	use \Bitphp\Core\Cache;

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
			$this->loaded = array();
			$this->variables = array();
		}

		protected function render() {
			foreach ($this->loaded as $file) {
				$this->source .= file_get_contents($file);
			}
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

			$this->loaded[] = $file;
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
			if(empty($this->loaded)) {
				$message  = 'No se pudo mostrar la(s) vista(s) ';
				$message .= 'ya que no se han cargado ninguna';
				trigger_error($message);
				return;
			}

			$data = Cache::isCached([$this->loaded, $this->variables]);

			if( false !== $data ) {
				$this->source = $data;
				echo $data;
				return;
			}

			$this->render();
			$_ROUTE = Globals::all();

			ob_start();
			extract($this->variables);
			eval("?> $this->source <?php ");
			$data = ob_get_clean();

			Cache::save([$this->loaded, $this->variables], $data);
			$this->clean();
			echo $data;
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