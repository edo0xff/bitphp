<?php namespace Bitphp\Modules\Layout;

	class Template extends View {

		public function __construct() {
			parent::__construct();
			$this->mime = '.tmpl.php';
		}

		private function compile($source) {
			$template_sintax = [
				  '<?'
				, '{if'
				, ':}'
				, '{elif'
				, '{else}'
				, '{/if}'
				, '{{'
				, '}}'
				, '{each'
				, '{/each}'
				, '{css '
				, ' css}'
				, '{js '
				, ' js}'
			];

			$php_sintax = [
				  '<?php'
				, '<?php if('
				, '): ?>'
				, '<?php elseif('
				, '<?php else: ?>'
				, '<?php endif ?>'
				, '<?php echo'
				, '?>'
				, '<?php foreach('
				, '<?php endforeach ?>'
				, '<link rel="stylesheet" href="<?php echo $_ROUTE[\'base_uri\'] ?>/public/css/'
				, '.css">'
				, '<script src="<?php echo $_ROUTE[\'base_uri\'] ?>/public/js/'
				, '.js"></script>'
			];

			return str_replace( $template_sintax, $php_sintax, $source );
		}

		public function render() {
			$this->source = $this->compile($this->source);
			return $this;
		}
	}