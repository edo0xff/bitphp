<!-- fisrt steeps -->
<h4>Primeros pasos</h4>
<hr>
<p>
  Puedes comenzar configurando algunos parámetros dentro del archivo
  <b>config.php</b>, que influyen en el funcionamiento de la aplicación,
  este archivo lo puedes encontrar en:
  <pre>
  core/
  └── config.php</pre>
  Para conocer en detalle el papel de cada uno de los parametros del <b>config.php</b>
  puedes visitar la
  <a href="http://bitphp.root404.com/docs/html/classes/Config.html" target="_blank">documentación.</a>
</p>
<hr>
<h4>Conociendo BitPHP</h4>
<hr>
<p>
  Hay ciertas cosas que debes saber de BitPHP, entre las cuales:
</p>
<ul>
  <li>
    <a href="../im_dont_exist">¿Que pasa cuando la URL solicitada no existe?</a>
  </li>
  <li>
    <a href="../home/gen_error">¿Que pasa si me equivoco al cargar algún elemento?</a>
  </li>
</ul>
<p>
  Las errores pueden mostrarse de una manera distinta, dentro del archivo <b>core/config.php</b>
  cambia la linea numero <b>34</b> de la siguiente manera:
</p>
<pre><code class="language-php">   /**
    * Indicates whether to display php errors
    */
    const DISPLAY_PHP_ERRORS = False;</code></pre>
<p>
  Y ahora observa que pasa con los enlaces anteriores.
</p>
<hr>
<h4>Ejemplos</h4>
<hr>
<p>
  Puedes comenzar con algunos ejemplos que hemos preparado:
</p>
<ul>
  <li><a href="#" data-toggle="modal" data-target="#ModalExample1">Hola mundo!.</a></li>
  <li><a href="#" data-toggle="modal" data-target="#ModalExample2">Recibiendo parámetros.</a></li>
  <li><a href="http://root404.com/blog/bitphp/guia-3/" target="_blank">Aplicacion de notas en 15min.</a></li>
</ul>
<!-- /fisrt steeps -->