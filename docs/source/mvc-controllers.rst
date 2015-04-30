Controladores
=============

Los controladores deben ser creados en la carpeta **app/controllers**, estos deben ser ficheros **.php** el nombre sel archivo determinara el nombre del controlador.

.. code::

   └── app/
       └── controllers /
           ├── controlador_1.php
           └── controlador_2.php
       ├── core/
       ├── public/
       ├── .htaccess
       └── index.php

Estructura de un controlador
----------------------------

La estructura de un controlador es una simple clase con algunos métodos, a estos métodos de aquí en adelante los llamaremos **acciones**, un controlador puede tener el siguiente aspecto:

.. code-block:: php

   <?php # app/controllers/mycontroller.php
      class MyController {
         public function action1() {
            /* do something ... */
         }

         public function action2() {
           /* do something ... */
         }
      }

La acción principal
+++++++++++++++++++

Un controlador debe de tener una **acción** qué se pueda usar en caso de qué no se indiqué ninguna otra:

.. code::

   http://example.com/mycontroller/action1
   # ejecuta la acción "action1" del controlador "mycontroller"

   http://example.com/mycontroller/action2
   # ejecuta la acción "action2" del controlador "mycontroller"

   http://example.com/mycontroller/
   # ¿Y aquí qué piensas qué se va a ejecutar?

A esto nos referimos cuando se dice qué **no se indico ninguna acción**, al notar esto bitphp debe buscar la acción principal del controlador, esta, por defecto, es la acción **main**, entonces:

.. code-block:: php

   <?php # app/controllers/mycontroller.php
      class MyController {
         public function main() {
             echo "Mensaje 1";
         }

         public function action1() {
            echo "Mensaje 2";
         }
      }

Con un controlador como el anterior pasa lo siguiente:

.. code::

   http://example.com/mycontroller/action1
   # muestra "Mensaje 2"
   
   http://example.com/mycontroller
   # muestra "Mensaje 1"

Nota: puedes definir como se debe llamar la acción principal, esto desde el `generador de archivos de configuración <getstarted.html#el-archivo-de-configuracion>`_  en el campo **acción predeterminada** o directamente del json del archivo de configuración en la propiedad **main_action.**

El controlador principal
++++++++++++++++++++++++

Es lo mismo qué sucede con la acción principal:

.. code::

   http://localhost/mycontroller/foo
   # ejecuta la acción "foo" del controlador "mycontroller"

   http://localhost/mycontroller
   # ejecuta la acción "main" del controlador "mycontroller"

   http://localhost/
   # ¿Y aquí qué hace?

En caso de no indicarse algún otro controlador bitphp buscara el *controlador principal* qué por defecto este debe llamarse **home**:

.. code-block:: php

   <?php # app/controllers/home.php

   class Home {
      public function main() {
         echo "Hola";
      }
   }

Por lo qué en dirreción **http://localhost/** bitphp busca el controlado **home** y ejecuta el método principal (*main*), el nombre qué debe tener el controlador principal se puede indicar en el archivo de configuración en la propiedad **main_controller** o desde el `generador de archivos de configuración <getstarted.html#el-archivo-de-configuracion>`_ en el campo **Controlador predeterminado**.

Entrada de datos
----------------

La entrada o recepción de datos, normalmente, con **php** la hacemos mediante diversos medios; **$_GET**, **$_POST**, **$_COOKIE** y también existe **$_REQUEST** qué engloba los anteriores, estas entradas, en cualquier aplicación, por seguridad y por demás cuestiones deben ser validadas y filtradas, **bitphp** nos ofrece métodos que proporcionan una capa de abstracción para realizar estas validaciones y filtros de manera sencilla:

$_POST, $_GET y $_COOKIE con bitphp
+++++++++++++++++++++++++++++++++++

Para leer, validar y filtrar los valores recibidos por **$_GET** debemos hacer uso del método **get()** de la clase **Input**, ej.

.. code-block:: php

   <?php
      use \BitPHP\Mvc\Input;
      class MyController {
          public function foo() {
             // equivalente a:
             // $name = isset( $_GET['nombre'] ) && $_GET['nombre'] !== '' ?  null : $_GET['nombre'] ;
             $name = Input::get('nombre');

             if( $name === null ) {
                echo "Se requiere un nombre";
                return 0;
             }

             echo "Hola $name";
          }
      }

.. code::

   http://example.com/mycontroller/foo?nombre=Juan
   # Muestra "Hola Juan"

   http://example.com/mycontroller/foo
   # Muestra "Se requiere un nombre"

Y así para los demás métodos:

.. code-block:: php

   <?php
      use \BitPHP\Mvc\Input;
      class MyController {
         public function foo() {
            // $_POST['index']
            $var1 = Input::post('index');
            // $_COOKIE['index']
            $cookie = Input::cookie('index');
         }
      }

Parámetros de url
+++++++++++++++++

Puedes recibir parámetros desde la url, esto las hará más amigables, la estructura de la url para bitphp tiene el siguiente significado::

   http://localhost/controller/action/param_0/param_1

Para poder leer estos parámetros de la url hacemos uso del método **urlParam()** de la clase **Input**, ejemplo:

.. code-block:: php

   <?php
      use \BitPHP\Mvc\Input
      class Mycontroller {
         public function foo() {
             $name = Input::urlParam(0);
             echo "Hola $name";
         }
      }

.. code::

   http://example.com/mycontroller/foo/Mundo
   # Muestra "Hola Mundo"

Podemos ver los parámetros de la url como un simple arreglo **http://example.com/controller/action/param0/param1/param2**, ya qué para leerlos van del **urlParam(0)**, **urlParam(1)**, etc. Pero también podemos verlos como un arreglo asociativo **clave => valor**, es decir, **http://example.com/controller/action/clave/valor/otra_clave/otro_valor**, ejemplo:

.. code-block:: php

   <?php
      use \BitPHP\Mvc\Input;
      class MyController {
         public function foo1() {
            $name = Input::urlParam('nombre');
            $age = Input::urlParam('edad');
            echo "$nombre tienes $edad años";
         }

         public function foo2() {
            $name = Input::urlParam(1);
            $age = Input::urlParam(3);
            echo "$nombre tienes $edad años";
         }

         public function foo3() {
            $name = Input::urlParam(0);
            $age = Input::urlParam(1);
            echo "$nombre tienes $edad años";
         }
      }

.. code::

   http://example.com/mycontroller/foo1/nombre/Pancho/edad/23
   # Muestra: Pancho tienes 23 años

   http://example.com/mycontroller/foo2/nombre/Pancho/edad/23
   # Muestra: Pancho tienes 23 años

   http://example.com/mycontroller/foo3/nombre/Pancho/edad/23
   # Muestra: nombre tienes Pancho años

   http://example.com/mycontroller/foo3/Pancho/23
   # Muestra: Pancho tienes 23 años

Filtrado de datos
+++++++++++++++++

La clase **Input** en todos sus métodos filtra los valores para evitar posibles inyecciones sql o xss. En caso de qué necesites de dichos valores sin filtrar (cuando requieras recibir algún valor *html* por ejemplo) puedes desactivar dicho filtro de la siguiente manera:

.. code-block:: php

   <?php
      use \BitPHP\Mvc\Input;
      class MyController {
         public function foo() {
            // el segundo parametro en false desactiva el filtro
         	$foo1 = Input::get('index', false);
         	$foo2 = Input::post('index', false);
         	$foo3 = Input::cookie('index', false);
         	$foo4 = Input::urlParam('index', false);
         }
      }

La clase BitController
======================

La clase **BitController** la podemos usar (o no) en cualquier momento para extender nuestros controladores, esto nos trae algunos beneficios (o no), por ejemplo, el uso directo de las clases de bitphp:

.. code-block:: php

   <?php

   class MyController extends BitController {
      public function foo() {
         $foo = $this->input->urlParam('name');
         echo "Tu nombre es: $foo";
      }
   }

   // versus

   <?php

   use \BitPHP\Mvc\Input;
   class MyController {
      public function foo() {
         $foo = Input::urlParam('name');
         echo "Tu nombre es $foo";
      }
   }

Y pasa lo mismo con el uso de algunas clases qué veremos más adelante, es cuestión de como te acomodes mejor, o como te guste más; *Usar las clases de forma estática* vs *Herencia*.