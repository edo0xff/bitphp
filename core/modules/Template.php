<?php

	use \BitPHP\Error;

	/**
  	*	@author Eduardo B <ms7rbeta@gmail.com>
  	*/
	class Template {

		public $template_source = '';
		public $template_vars = array();
		public $result = null;

		private function clean() {
			$this->template_source = '';
			$this->template_vars = array();
			$this->result = null;
		}

		private function compile() {

			global $bitphp;
			$_ROUTE = $bitphp->route;

			$sword_sintax = [
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
				, '<link rel="stylesheet" type="text/css" href="'.$_ROUTE['PUBLIC'].'/css/'
				, '.css">'
				, '<script src="'.$_ROUTE['PUBLIC'].'/js/'
				, '.js"></script>'
			];

			return str_replace( $sword_sintax, $php_sintax, $this->template_source );
		}

		public function load( $templates ) {

			$this->clean();

			global $bitphp;
			$_ROUTE = $bitphp->route;

			$templates = is_array($templates) ? $templates : [$templates];
      		$i = count($templates);

      		for($j = 0; $j < $i; $j++) {
	        	$read = @file_get_contents( $_ROUTE['APP_PATH'] .'/views/'.$templates[$j].'.tmpl.php' );

        		if($read === FALSE){
	          		$m = 'Error al renderizar "'.$templates[$j].'".';
          			$c = 'El fichero "/' . $_ROUTE['APP_PATH'] .'/views/'.$templates[$j].'.tmpl.php" no existe.';
          			$bitphp->error->trace($m, $c);
		    	}

        		$this->template_source .= $read;
      		}

      		return $this;
		}

		public function vars( $vars ) {
			
			$this->template_vars = $vars;
			return $this;
		}

		public function render() {

			global $bitphp;
			$_ROUTE = $bitphp->route;

			if( $this->template_source == '' ) {
				$m = 'No se puede renderizar.';
				$e = 'No se a cargado ninguna plantilla "Template::load" o la plantilla esta en blanco.';
				$bitphp->error->trace( $m, $e );
			}

			extract( $this->template_vars );
			$compiled_source = $this->compile();

			ob_start();
			eval('?> ' . $compiled_source . '<?php ' );
			$this->result = ob_get_clean();

			return $this;
		}

		public function read() {
			global $bitphp;

			if( !$this->result ) {
				$m = 'No se puede leer la plantilla.';
				$e = 'Aun no se ha renderizado "Template::render".';
				$bitphp->error->trace( $m, $e );
			}

			return $this->result;
		}

		public function draw() {
			global $bitphp;

			if( !$this->result ) {
				$m = 'No se puede imprimir la plantilla.';
				$e = 'Aun no se ha renderizado "Template::render".';
				$bitphp->error->trace( $m, $e );
			}

			echo $this->result;
		}

		public function quickDraw( $tmpl, $vars = array() ) {
			$template = new Template();
			$template->load( $tmpl )->vars( $vars )->render()->draw();
			$template = null;
		}
	}