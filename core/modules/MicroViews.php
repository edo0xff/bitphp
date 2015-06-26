<?php

    use \BitPHP\Error;

    /**
    *   @author Eduardo B <ms7rbeta@gmail.com>
    */
    class MicroViews {

        public $template_vars = array();
        public $result = '';

        private function clean() {
            $this->template_vars = array();
            $this->result = '';
        }


        public function load( $templates ) {

            $this->clean();

            global $bitphp;
            $_ROUTE = $bitphp->route;
            $this->template_vars['_ROUTE'] = $bitphp->route;

            $templates = is_array($templates) ? $templates : [$templates];
            $i = count($templates);

            for($j = 0; $j < $i; $j++) {
                $read = @file_get_contents( $_ROUTE['APP_PATH'] .'/views/'.$templates[$j].'.php' );

                if($read === FALSE){
                    $m = 'Error al cargar la vista "'.$templates[$j].'".';
                    $c = 'El fichero "/' . $_ROUTE['APP_PATH'] .'/views/'.$templates[$j].'.php" no existe.';
                    $bitphp->error->trace($m, $c);
                }

                $this->result .= $read;
            }

            return $this;
        }

        public function vars( $vars ) {
            global $bitphp;
            
            $this->template_vars = $vars;
            $this->template_vars['_ROUTE'] = $bitphp->route;
            return $this;
        }

        public function read() {
            global $bitphp;

            if( !$this->result ) {
                $m = 'No se puede leer la vista.';
                $e = 'Aun no se ha cargado o esta vacia!';
                $bitphp->error->trace( $m, $e );
            }

            extract( $this->template_vars );

            ob_start();
            eval('?> ' . $this->result . '<?php ' );
            $this->result = ob_get_clean();

            return $this->result;
        }

        public function draw() {
            global $bitphp;

            if( !$this->result ) {
                $m = 'No se puede imprimir la vista.';
                $e = 'Aun no se ha cargado o esta vacia!';
                $bitphp->error->trace( $m, $e );
            }

            extract( $this->template_vars );
            eval('?> ' . $this->result . '<?php ' );
        }

        public function quickDraw( $tmpl, $vars = array() ) {
            $template = new MicroViews();
            $template->load( $tmpl )->vars( $vars )->draw();
            $template = null;
        }
    }