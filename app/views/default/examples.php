<!-- ModalExample1 -->
<div aria-hidden="true" aria-labelledby="example1" role="dialog" tabindex="-1" id="ModalExample1" class="modal fade">
         <div class="modal-dialog modal-lg">
               <div class="modal-content">
                   <div class="modal-header">
		       <button type="button" class="close btn-close" data-dismiss="modal">
			<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
		       </button>
                       <h4 class="modal-title">¡Como crear un hola mundo!</h4>
                   </div>
                   <div class="modal-body">
			<p>
			Lo primero que necesitas es crear un controlador, recuerda que los controladores
			se guardan en la carpeta:
			</p>
			<pre>
  app/
  └── controllers/
      ├──controlador1.php
      ├──controlador2.php
      └──controlador3.php</pre>
			<p>
			Entonces dentro de dicha carpeta crearemos el archivo <b>hello.php</b> el cual
			tendrá en siguiente contenido:
			</p>
			<pre><code class="language-php">&#60;?php
  // app/controllers/hello.php
  class Hello {
    public function index() {
      \BitPHP\Load::view('hello/index');
    }
  }
?&#62;</code></pre>
			<p>
			Como puedes notar estamos cargando una vista dentro del método <b>index</b> del
			controlador, por lo tanto debemos crearla :D, recuerda que las vistas van dentro
			de la carpeta <b>views</b> y pueden organizarse de la siguiente manera:
			</p>
			<pre>
  app/
  └── views/
      ├──vista1.php
      ├──controlador1/
      │  ├──vista1.php
      │  └──vista2.php
      └──controlador2/
         ├──vista1.php
         └──vista2.php</pre>
			<p>
			Es decir, que podemos crear una carpeta con vistas para cada controlador, y de esta manera
			tener una mejor organización de la aplicación.
			</p>
			<p>
			Bien, entonces crearemos una vista llamada <b>index.php</b> dentro de la carpeta
			<b>app/views/hello/</b>, con el siguiente contenido:
			</p>
			<pre><code class="language-markup">&#60;!-- /app/views/hello/index.php --&#62;
&#60;h1&#62;Hola mundo!&#60;/h1&#62;</code></pre>
			<p>
			Ahora, si todo va bien, podemos entrar a la dirección <b>http://server-address/hello</b> y
			visualizar el resultado.
                       </p>
                   </div>
                   <div class="modal-footer">
                       <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                   </div>
               </div>
           </div>
</div>
<!-- /ModalExample1 -->
<!-- ModalExample2 -->
<div aria-hidden="true" aria-labelledby="example1" role="dialog" tabindex="-1" id="ModalExample2" class="modal fade">
         <div class="modal-dialog modal-lg">
               <div class="modal-content">
                   <div class="modal-header">
		       <button type="button" class="close btn-close" data-dismiss="modal">
			<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
		       </button>
                       <h4 class="modal-title">Recibiendo parámetros.</h4>
                   </div>
                   <div class="modal-body">
			<p>
			  Existen diversas formas en las que podemos recibir parametros dentro de nuestro controlador
			  las mas comunes son aquellas que ya conocemos; <b>$_POST,</b><b>$_GET,</b><b>$_COOKIE</b>, ademas
        con BitPHP se pueden enviar parametros a traves de la URL:
			</p>
      <pre>http://example.com/controller/method/<b>param_1</b>/<b>param_2</b></pre>
      <p>
        Los primeros 3 los podemos obtener de la manera clasica, o bien, con la clase <b>\BitPHP\Input</b>
        con la cual el obtener y validar diversos datos se nos facilitara bastante, ademas ayuda a la
        seguridad de la aplicacion ya que aplica un filtro a las entradas de datos para evitar posibles
        inyecciones de codigo:
      </p>
      <pre><code class="language-php">&#60;?php
  class Foo {
    
    public function index() {
      //Valida, obtiene y filtra $_POST['foo']
      $foo = \BitPHP\Input::post('foo');
      //Valida, obtiene y filtra $_GET['foo2']
      $foo2 = \BitPHP\Input::get('foo2');
      //Valida, obtiene y filtra param1 &#60;http://example.com/foo/index/param0/param1&#62;
      $foo3 = \BitPHP\Input::url_param(1);
    }

  }
?&#62;</code></pre>
        <hr>
        <h4>Ejemplo practico</h4>
        <p>
          Vamos a validar un correo electronico, un nombre de usuario, y una contraseña con las siguientes 
          caracteristicas:
        </p>
        <ul>
          <li>El correo electronico debe tener el formato <b>foo@example.foo</b>.</li>
          <li>El nombre de usuario no debe exceder los 25 caracteres.</li>
          <li>Verificar si las contraseñas coinciden.</li>
        </ul>
        <p>
          Primero crearemos la vista <b>app/views/validar/index.php</b> y dentro de ella escribimos:
        </p>
        <pre><code class="language-markup">&lt;html&gt;
  &lt;head&gt;
    &lt;meta charset=&quot;utf8&quot;&gt;
    &lt;title&gt;Validaci&oacute;n de datos&lt;/title&gt;
  &lt;/head&gt;
  &lt;body&gt;
    &lt;!-- /validar/submit si bitphp se encuentra corriendo en la ra&iacute;z del servidor --&gt;
    &lt;form action=&quot;/validar/submit&quot; method=&quot;POST&quot;&gt;
      &lt;input type=&quot;text&quot; name=&quot;user&quot; placeholder=&quot;Usuario&quot;&gt;&lt;/input&gt;
      &lt;input type=&quot;text&quot; name=&quot;email&quot; placeholder=&quot;Correo&quot;&gt;&lt;/input&gt;
      &lt;input type=&quot;password&quot; name=&quot;pass1&quot; placeholder=&quot;Contrase&ntilde;a&quot;&gt;&lt;/input&gt;
      &lt;input type=&quot;password&quot; name=&quot;pass2&quot; placeholder=&quot;Confirmar contrase&ntilde;a&quot;&gt;&lt;/input&gt;
      &lt;button type=&quot;submit&quot;&gt;Enviar&lt;/button&gt;
    &lt;/form&gt;
    &lt;div id=&quot;error&quot;&gt;
      &lt;?php echo isset($error) ? $error : ''; ?&gt;
    &lt;/div&gt;
  &lt;/body&gt;
&lt;/html&gt;</code></pre>
          <p>
            Lo siguiente es crear el controlador <b>app/controllers/validar.php</b> dentro del cual
            pondremos:
          </p>
          <pre><code class="language-php">&lt;?php
  
  class Validar {

    public function index() {
      \BitPHP\Load::view('validar/index');
    }

    public function submit() {
      $user  = \BitPHP\Input::large_as('POST','user',25);
      $email = \BitPHP\Input::email('POST','email');
      $pass  = \BitPHP\Input::pass('POST',['pass1','pass2']);
      $error = '';

      $error .= $user  ? '' : '&lt;br&gt;El usuario no se indico o excede los 25 caracteres!';
      $error .= $email ? '' : '&lt;br&gt;El email no se indico o no es valido!';
      $error .= $pass  ? '' : '&lt;br&gt;Las contraseñas no son seguras o no coinciden!';

      if($error) {
        \BitPHP\Load::view('validar/index',['error' =&gt; $error]);
        return 0;
      }

      echo '&lt;br&gt;Usuario: ', $user;
      echo '&lt;br&gt;Email: ', $email;
      echo '&lt;br&gt;Contraseña:', $pass;

    }
  }

?&gt;</code></pre>
            <p>
              Ahora entra a la direccion <b>http://example.com/validar</b> para ver y probar los 
              resultados :D
            </p>
                   </div>
                   <div class="modal-footer">
                       <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                   </div>
               </div>
           </div>
</div>
<!-- /ModalExample2 -->