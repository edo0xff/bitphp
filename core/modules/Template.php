<?php
	
	use \BitPHP\Config;
	use \BitPHP\Error;
	
	class Template {

	/**
    * Attempts to load and display the specified view, but you can use {$_foo} instead of <?php echo $_foo ?>.
    *
    * @param string $_name Name of the helper to be loaded, without extension.
    * @param mixed $_values Parameters that could send to template.
    * @return void
    */
    public function render($_tmplts, $_values = array()) {
      global $_APP;
      $_PUBLIC_PATH = Config::base_path() . 'public';

      $_content = '';
      $_search   = ['<?','{if',':}','{elif','{el}','{/if}','{{','}}','{each','{/each}','{css ',' css}'];
      $_replace  = ['<?php','<?php if(','): ?>','<?php elseif(','<?php else: ?>','<?php endif ?>',
        '<?php echo','?>','<?php foreach(','<?php endforeach ?>',
        '<link rel="stylesheet" type="text/css" href="'.$_PUBLIC_PATH.'/css/','.css">'];

      // Para poder cargar mas de un template de una sola vez
      $_tmplts = is_array($_tmplts) ? $_tmplts : [$_tmplts];
      $_i = count($_tmplts);

      for($_j = 0; $_j < $_i; $_j++) {
        $_read = @file_get_contents( $_APP .'/views/'.$_tmplts[$_j].'.pht' );

        if($_read === FALSE){
          $_m = 'Error al renderizar <b>'.$_tmplts[$_j].'</b>';
          $_c = 'El fichero <b>../' . $_APP .'/views/'.$_tmplts[$_j].'.pht</b> no existe!';
          Error::trace($_m, $_c);
          return 0;
        }

        $_content .= $_read;
      }

        extract($_values);
        $_PATH = Config::base_path();
        $_content = str_replace($_search, $_replace, $_content);
        eval('?> '.$_content.'<?php ');
    }
} ?>