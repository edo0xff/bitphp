<?php 

	namespace Bitphp\Modules\Layout;

	use \Bitphp\Core\Config;
	use \Bitphp\Core\Cache;

	class Medusa extends View {

		protected function render() {
			parent::render();

			$this->source = $this->compile($this->source);

			$compress = Config::param('medusa.compress');
			if(false !== $compress)
				$this->source = $this->compress($this->source);
		}

		public function __construct() {
			parent::__construct();
			$this->mime = '.medusa.php';
		}

		public function compile($source) {
			$rules = [
				  # Medusa comment
				  '/\/\*(.*)?\*\//Usx'
				  # html comment
				, '/\/\-(.*)?\-\//Usx'
				  #echo
				, '/\{\{(.*)\}\}/U'
				  #css files
				, '/:css(\s+)+(.+)/'
				  #js files
				, '/:js(\s+)+(.+)/'
				  #if|elseif statement
				, '/:(if|elseif|for|foreach)(\s+)+(.*)/'
				  #end statements
				, '/:(endif|endforeach|endfor)/'
				  #else
				, '/:else/'
				  #layouts with params
				, '/:(require|include)(\s+)?(\S+)(\s+)?(\s+)*(\[(.*)\]|@args)/Usx'
				  #layout without params
				, '/:(require|include)(\s+)?(\S+)/'
				  #arrays utility
				, '/\$(\w+)\.(\w+)/'
				  #array of template vars
				, '/:args/'
				  #app link
				, '/:base/'
				  #create vars
				, '/:var(\s+)+(\w+)(\s+)+(.+)/'
			];

			$replaces = [
				  ''
				, '<!--$1-->'
				, '<?php echo $1 ?>'
				, '<link rel="stylesheet" href="<?php echo $_ROUTE[\'base_uri\'] ?>/public/css/$2.css">'
				, '<script scr="<?php echo $_ROUTE[\'base_uri\'] ?>/public/js/$2.js"></script>'
				, '<?php $1 ($3): ?>'
				, '<?php $1; ?>'
				, '<?php else: ?>'
				, '<?php \Bitphp\Modules\Layout\Medusa::quick(\'$3\', $6); ?>'
				, '<?php \Bitphp\Modules\Layout\Medusa::quick(\'$3\'); ?>'
				, '$$1["$2"]'
				, '$this->variables'
				, '$_ROUTE[\'base_uri\']'
				, '<?php $$2 = $4 ?>'
			];

			return preg_replace($rules, $replaces, $source);
		}

		public function compress($data) {
			$rules = [
				  '#(?ix)(?>[^\S ]\s*|\s{2,})(?=(?:(?:[^<]++|<(?!/?(?:textarea|pre)\b))*+)(?:<(?>textarea|pre)\b|\z))#'
			];

			$replaces = [
				  ''
			];

			return preg_replace($rules, $replaces, $data);
		}

		public static function quick($name, $vars = array()) {
			$loader = new Medusa();
			$loader->load($name)
				   ->with($vars)
				   ->draw();
			$loader = null;
		}
	}