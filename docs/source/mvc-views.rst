Vistas
======

Las vistas deben de crearse en la carpeta **app/views/** con extensión  **.php**, el nombre de la vista viene dado por el nombre del archivo.

.. code::

    └── app/
        └── views /
            ├── vista_1.php
            └── vista_2.php
    ├── core/
    ├── public/
    ├── .htaccess
    └── index.php

Estructura
~~~~~~~~~~

Como ya sabemos, en la arquitecturas mvc, las vistas son la interfaz de usuario, entonces una vista será un archivo qué contiene html, por lo qué una vista puede tener el siguiente aspecto:

.. code-block:: html

   <!-- app/views/hola.php -->
   <h4>Hola mundo</h4>

O el siguiente:

.. code-block:: html

   <!-- app/views/hola.php -->
   <html>
      <head>
         <title>Hola!</title>
      </head>
      <body>
         <h4>Hola mundo!</h4>
      </body>
   </html>

Como usar las vistas
~~~~~~~~~~~~~~~~~~~~

Para poder mostrar las vistas al usuario estas deben ser cargadas desde el controlador, para ello hacemos uso del método **view** de la clase **Load**, ejemplo:

.. code-block:: php

   <?php
      use \BitPHP\Mvc\Load;
      class MyController {
         public function hello() {
            // No es necesario indicar la extensíon .php
            Load::view('nombre_de_la_vista');
         }
      }

   // o también

   <?php
      class MyController extends BitController {
         public function hello() {
            $this->load->view('nombre_de_la_vista');
         }
      }

Podemos cargar varias vista de una sola vez:

.. code-block:: php

   <?php
      use \BitPHP\Mvc\Load;
      class MyController {
         public function hello() {
            Load::view([
                  'vista_1'
                , 'vista_2'
                , 'vista_3'
            ]);
         }
      }

   // o también

   <?php
      class MyController extends BitController {
         public function hello() {
            $this->load->view([
                  'vista_1'
                , 'vista_2'
                , 'vista_3'
            ]);
         }
      }

Ejemplo
-------

Nosotros tenemos un servicio mvc de bitphp instalado en la carpeta **/bit** (*http://localhost/bit/*) de nuestro servidor, hemos creado una serie de vistas con el siguiente contenido:

.. code-block:: html
   
   <!-- app/views/header.php -->
   <html>
      <head>
         <meta charset="utf8">
         <title> Hola </title>
      </head>
      <body>

.. code-block:: html

   <!-- app/views/content_1.php -->
   <h4>Hola mundo</h4>

.. code-block:: html

   <!-- app/views/content_2.php -->
   <h4>Adiós mundo cruel!</h4>

.. code-block:: html

   <!-- app/views/footer.php -->
         <p>Pie de página</p>
      </body>
   </html>

Entonces creamos un controlador llamado **say** de la siguiente forma:

.. code-block:: php

   <?php # app/controllers/say.php
      use \BitPHP\Mvc\Load;
      class Say {
         public function msg1() {
            Load::view([
                  'header'
                , 'content_1'
                , 'footer'
            ]);
         }

         public function msg2() {
            Load::view([
                  'header'
                , 'content_2'
                , 'footer'
            ]);
         }
      }

Y los resultados qué tenemos son:

.. image:: images/img-views-1.png

Cargando vistas dentro de las vitas
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Si, también puedes cargar una vista desde otra vista, esto, usando de manera estatica el metodo **view** de la clase **Load**:

.. code-block:: html

   <!-- app/views/foo_view -->
   <div class="panel">
      <!-- aquí se mostraría la vista "view_menu" -->
      <?php \BitPHP\Mvc\Load::view('view_menu') ?>
   </div>

PHP dentro de las vistas
~~~~~~~~~~~~~~~~~~~~~~~~

Podemos usar php dentro de las vistas en cualquier momento, como cualquier otro código php embebido:

.. code-block:: php

   <!-- app/views/foo.php -->
   <html>
      <head>
         <title>Foo title</title>
      </head>
      <body>
         <ul>
            <?php for( $i = 1; $i <= 10; $i++ ): ?>
               <li>Numero: <?php echo $i ?></li>
            <?php endfor ?>
         </ul>
      </body>
   </html>

Pasando variables a una vista
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Para enviar variables a las vistas, para qué estas las puedan usar y/o mostrar al usuario, primero debemos colocarlas en un arreglo asociativo de la manera **nombre_de_la_variable** => **valor**, y después pasarlas como segundo parámetro en el método **view** de la clase **Load**, ejemplo:

.. code-block:: php

   <?php # app/controllers/mycontroller.php
   use \BitPHP\Mvc\Load;
   class MyController {
      public function foo() {
         $vars = [
              'var1' => 'Some thing.'
            , 'var2' => 'Other thing,'
         ];
         Load::view('foo_view', $vars);
      }
   }
   
   // o también
   
   <?php # app/controllers/mycontroller.php
   class MyController extends BitController {
      public function foo() {
         $vars = [
              'var1' => 'Some thing.'
            , 'var2' => 'Other thing,'
         ];
         $this->load->view('foo_view', $vars);
      }
   }
   
Entonces dentro de todas las vistas qué cargues estarán disponibles las variables, **si cargas 4 vistas en las cuatro estarán disponibles**, las claves del arreglo qué pasaste en el segundo parámetro se convierten en variables con su respectivo valor, es decir, debes usarlas de la siguiente manera:

.. code-block:: php

   <?php # app/controllers/mycontroller.php
   use \BitPHP\Mvc\Load;
   class MyController {
      public function foo() {
         $vars = [
              'nombre' => 'Jacinto.'
            , 'edad' => 23
         ];
         Load::view([
              'foo_view_1'
            , 'foo_view_2'
         ], $vars);
         
         Load::view('foo_view_3');
      }
   }   
   
.. code-block:: html

   <!-- app/views/foo_view_1.php -->
   <h4>Hola <?php echo $nombre ?> tienes <?php echo $edad ?> años!</h4>

.. code-block:: html

   <!-- app/views/foo_view_2.php -->
   <?php if( $edad > 18 ): ?>
      <h4>Hola <?php echo $nombre ?> eres mayor de edad!</h4>
   <?php endif ?>
   
.. code-block:: html

   <!-- app/views/foo_view_3.php -->
   <h4>Tu nombre es: <?php echo $nombre ?>!</h4>
   <!-- 
      Esto da un ERROR ya qué las variables no fueron
      pasadas al metodo qué cargo "foo_view_3"
    -->

La variable $_ROUTE
~~~~~~~~~~~~~~~~~~~

Dentro de las vistas en cualquier momento podemos hacer uso de la variable **$_ROUTE** la cual contiene varios campos útiles, tales como; Rutas (links) a la carpeta publica de la aplicación, a la misma aplicación, haciendo un **print_r()** nos podemos dar cuenta de los parámetros qué nos proporciona (nuestra instalacion de *bitphp* se encuentra en *localhos/bit*):

.. code::

   Array
   (
       [BASE_PATH] => /bit
       [URL] => Array ()
       [APP_PATH] => app
       [APP_CONTROLLER] => home
       [APP_ACCTION] => index
       [SERVER_NAME] => http://localhost
       [APP_LINK] => http://localhost/bit
       [PUBLIC] => http://localhost/bit/public
   )

Algunos de los usos más utiles qué tiene es para crear enlaces (*links*) a alguna parte de la aplicación, por ejemplo, para crear un enlace a el controlador **mycontrolador** puedes, tipicamente, hacer lo siguiente:

.. code-block:: html
   
   <!-- app/views/foo_view.php -->
   <a href="http://localhost/mycontrolador">Ir a mycontrolador</a>
   <!-- o así -->
   <a href="/mycontrolador">Ir a mycontrolador</a>

Pero imagina que migras tu aplicación a un servidor en linea *http://example.com*, la primera de las anteriores formas entraría en conflicto, la segunda no tendría problemas, pero digamos qué tu aplicación la subes en la dirección *http://example.com/myapp/* es cuando la segunda forma fallaría, o a un servidor con ssl *https://example.com* allí ambas fallarían, entonces tendrías que estar cambiando tus links, pero, ¿cual es la mejor solución? simple:

.. code-block:: html

   <!-- app/views/foo_view.php -->
   <a href="<?php echo $_ROUTE['APP_LINK'] ?>/mycontrolador">Ir a mycontrolador</a>
   <script src="<?php echo $_ROUTE['PUBLIC'] ?>/js/foo.js"></script>

Y de esta manera no importa a donde muevas la aplicación, el enlace siempre se va adaptar.

Como mantener mejor organizadas tus vistas
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Para mantener mejor organizadas tus vistas puedes separarlas en carpetas según diversos criterios, por ejemplo, puedes separar las vistas qué solo son usadas por un controlador en una carpeta aparte de las qué son usadas por otro controlador, o separar las vistas qué corresponden al administrador de las vistas qué corresponden al usuario:

.. code::

    └── app/
        └── views /
            └── admin/
                ├── editor.php
                ├── panel.php
                └── foo.php
            ├── user/
                └── components/
                    ├── toolbar.php
                    ├── menu.php
                    └── foo.php    
                ├── home.php
                ├── profile.php
                └── foo.php    
            ├── header.php
            └── footer.php
    ├── core/
    ├── public/
    ├── .htaccess
    └── index.php

Y las cargas haciendo referencia a la ruta donde se encuentran:

.. code-block:: php

   <?php
   class MyController extends BitController {
      public function main() {
         $this->load->view([
              'header'
            , 'user/profile'
            , 'footer'
         ]);
      }
   }
   
   // o
   
   <?php
   use \BitPHP\Mvc\Load;
   class MyController {
      public function main() {
         Load::view([
              'header'
            , 'admin/panel'
            , 'footer'
         ]);
      }
   }

Motor de plantillas
~~~~~~~~~~~~~~~~~~~

El motor de platillas es una herramienta qué nos facilita el manejo de datos dentro de las vistas, por ejemplo, esto:

.. code-block:: html

   <!-- app/views/foo.php -->
   <h4>Hola <?php echo $nombre ?>!</h4>
   <p>
      Tienes <?php echo $age ?> años!
   </p>
   <p>
      <?php if( $age > 18 ): ?>
         Eres mayor de edad!
      <?php else: ?>
         Eres menor de edad
      <?php endif ?>
   </p>
   
Usando una plantilla lo podemos reducir a esto:

.. code-block:: html

   <!-- app/views/foo.tmpl.php -->
   <h4>Hola {{ $nombre }}!</h4>
   <p>
      Tienes {{ $age }} años!
   </p>
   <p>
      {if $age > 18 :}
         Eres mayor de edad!
      {else}
         Eres menor de edad
      {/if}
   </p>
   
La sintaxis del motor de plantillas no es nada complicada, puedes leer mas sobre el motor de plantillas `aquí. <mvc-modules.html#template>`_