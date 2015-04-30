Acerca de bitphp
================

Algúnos frameworks son lo *bastante complejos* como para pasar horas , incluso días, aprendiendo a usarlos y a raíz de esto es qué surge **bitphp**, nuestra misión es crear un marco de trabajo óptimo en todos los aspectos, rápido en la ejecución, rápido en el desarrollo y, por supuesto, fácil de aprender.

Filosofía
=========

*"Grandes problemas, pequeñas soluciones"*
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Creemos firmemente qué no importa la complejidad del problema o necesidad qué debas resolver, todo puede, y debe, tener una solución sencilla y elegante.

.. code-block:: php

   <?php
      $myApp = $bitphp->loadGreatApp();
      $myApp->makeDreams();

Características
===============

- **Soporte a diversas arquitecturas:** (MVC/HMVC/Micro MVC/RestFUL Service). 
- **Velocidad:** la ejecución de bitphp es realmente rápida.
- **Ligereza:** su núcleo tiene apenas unos cuantos KBytes
- **Minimalismo:** nos esforzamos en lograr qué las aplicaciones puedan tener un código limpio y fácil de entender.
- **Naturaleza modular:** se puede extender su funcionalidad fácilmente a través de la creación de módulos.

Micro Benchmark
===============

Se ha creado una prueba de rendimiento en la qué cada framework recibirá un parametro **"nombre"** y deberá imprimir un mensage **"Hola $nombre"**, para esta prueba se ha tomado en cuenta la velocidad de respuesta de cada framework.

Frameworks usados
~~~~~~~~~~~~~~~~~

- Slim
- Silex
- BitPHP

Ejecutando una prueba con 1000 conexiones a 5 concurrentes.

Slim
~~~~

Código
------

.. code-block:: php

   <?php
      require 'Slim/Slim.php';
      \Slim\Slim::registerAutoloader();
      $app = new \Slim\Slim();

      $app->get('/hello/:name', function ($name) {
         echo "Hola $name!";
      });

      $app->run();
   ?>

Resultado
---------

.. code::

   ab -H "Connection:close" -n 1000 -c 5 http://localhost/benchmark/slim/hello/Mundo
   This is ApacheBench, Version 2.3 <$Revision: 1528965 $>
   Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
   Licensed to The Apache Software Foundation, http://www.apache.org/

   Benchmarking localhost (be patient)
   Completed 100 requests
   Completed 200 requests
   Completed 300 requests
   Completed 400 requests
   Completed 500 requests
   Completed 600 requests
   Completed 700 requests
   Completed 800 requests
   Completed 900 requests
   Completed 1000 requests
   Finished 1000 requests


   Server Software:        Apache/2.4.7
   Server Hostname:        localhost
   Server Port:            80

   Document Path:          /benchmark/slim/hello/Mundo
   Document Length:        21 bytes

   Concurrency Level:      5
   Time taken for tests:   0.574 seconds
   Complete requests:      1000
   Failed requests:        0
   Total transferred:      198000 bytes
   HTML transferred:       11000 bytes
   Requests per second:    1743.42 [#/sec] (mean)
   Time per request:       2.868 [ms] (mean)
   Time per request:       0.574 [ms] (mean, across all concurrent requests)
   Transfer rate:          337.11 [Kbytes/sec] received

   Connection Times (ms)
                 min  mean[+/-sd] median   max
   Connect:        0    0   0.0      0       0
   Processing:     1    3   1.4      2      10
   Waiting:        1    3   1.3      2      10
   Total:          1    3   1.4      2      10

   Percentage of the requests served within a certain time (ms)
     50%      2
     66%      3
     75%      4
     80%      4
     90%      5
     95%      5
     98%      7
     99%      8
    100%     10 (longest request)

Silex
~~~~~

Código
------

.. code-block:: php

   <?php

      require_once __DIR__.'/../vendor/autoload.php';

      $app = new Silex\Application();

      $app->get('/hello/{name}', function($name) use($app) { 
         return "Hello $name!";
      }); 

      $app->run();

   ?>

Resultado
---------

.. code::

   ab -n 1000 -c 5 http://localhost/benchmark/silex/hello/Mundo
   This is ApacheBench, Version 2.3 <$Revision: 1528965 $>
   Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
   Licensed to The Apache Software Foundation, http://www.apache.org/

   Benchmarking localhost (be patient)
   Completed 100 requests
   Completed 200 requests
   Completed 300 requests
   Completed 400 requests
   Completed 500 requests
   Completed 600 requests
   Completed 700 requests
   Completed 800 requests
   Completed 900 requests
   Completed 1000 requests
   Finished 1000 requests


   Server Software:        Apache/2.4.7
   Server Hostname:        localhost
   Server Port:            80

   Document Path:          /benchmark/silex/hello/Mundo
   Document Length:        11 bytes

   Concurrency Level:      5
   Time taken for tests:   1.372 seconds
   Complete requests:      1000
   Failed requests:        0
   Total transferred:      288000 bytes
   HTML transferred:       11000 bytes
   Requests per second:    728.61 [#/sec] (mean)
   Time per request:       6.862 [ms] (mean)
   Time per request:       1.372 [ms] (mean, across all concurrent requests)
   Transfer rate:          204.92 [Kbytes/sec] received

   Connection Times (ms)
                 min  mean[+/-sd] median   max
   Connect:        0    0   0.2      0       3
   Processing:     3    7   3.5      5      43
   Waiting:        2    6   3.0      5      39
   Total:          3    7   3.5      6      43

   Percentage of the requests served within a certain time (ms)
     50%      6
     66%      7
     75%      8
     80%      9
     90%     11
     95%     13
     98%     16
     99%     18
    100%     43 (longest request)

BitPHP
~~~~~~

Código
------

.. code-block:: php

   <?php require( 'core/bit.php' );
  
      $myApp = $bitphp->loadMicroServer();

      $myApp->route('/hello/:word', function( $name ) {
         echo "Hola $name!";
      });

      $myApp->run();
   ?>

Resultado
---------

.. code::

   $ ab -n 1000 -c 5 http://localhost/benchmark/bitphp/hello/Mundo
   This is ApacheBench, Version 2.3 <$Revision: 1528965 $>
   Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
   Licensed to The Apache Software Foundation, http://www.apache.org/

   Benchmarking localhost (be patient)
   Completed 100 requests
   Completed 200 requests
   Completed 300 requests
   Completed 400 requests
   Completed 500 requests
   Completed 600 requests
   Completed 700 requests
   Completed 800 requests
   Completed 900 requests
   Completed 1000 requests
   Finished 1000 requests


   Server Software:        Apache/2.4.7
   Server Hostname:        localhost
   Server Port:            80

   Document Path:          /benchmark/bitphp/hello/Mundo
   Document Length:        21 bytes

   Concurrency Level:      5
   Time taken for tests:   0.222 seconds
   Complete requests:      1000
   Failed requests:        0
   Total transferred:      208000 bytes
   HTML transferred:       21000 bytes
   Requests per second:    4509.30 [#/sec] (mean)
   Time per request:       1.109 [ms] (mean)
   Time per request:       0.222 [ms] (mean, across all concurrent requests)
   Transfer rate:          915.95 [Kbytes/sec] received

   Connection Times (ms)
                 min  mean[+/-sd] median   max
   Connect:        0    0   0.0      0       0
   Processing:     0    1   0.5      1       4
   Waiting:        0    1   0.5      1       4
   Total:          0    1   0.6      1       4

   Percentage of the requests served within a certain time (ms)
     50%      1
     66%      1
     75%      1
     80%      1
     90%      2
     95%      2
     98%      3
     99%      3
    100%      4 (longest request)

Resultados
~~~~~~~~~~

+-------------+------------------------+---------------------+
|  Framework  | Peticiones por segundo | Tiempo por petición |
+=============+========================+=====================+
|  Slim       | 1743.42 [#/sec]        | 2.868 [ms]          |
+-------------+------------------------+---------------------+
|  Silex      | 728.61 [#/sec]         | 6.862 [ms]          |
+-------------+------------------------+---------------------+
|  BitPHP     | 4509.30 [#/sec]        | 1.109 [ms]          |
+-------------+------------------------+---------------------+

- *Peticiones por segundo: entre más, mejor.*
- *Tiempo por petición: entre menos, mejor.*

MVC Benchmark
=============

Frameworks usados
~~~~~~~~~~~~~~~~~

- CodeIgniter

CodeIgniter
~~~~~~~~~~~

Código del controlador
----------------------

.. code-block:: php

   <?php

      class Hello extends CI_Controller {

         public function index()
         {
            $this->load->view('hello_message');
         }
      }

Resultado
---------

.. code::
   
   $ ab -n 2000 -c 10 http://localhost/benchmark2/codeigniter/index.php/hello
   This is ApacheBench, Version 2.3 <$Revision: 1528965 $>
   Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
   Licensed to The Apache Software Foundation, http://www.apache.org/

   Benchmarking localhost (be patient)
   Completed 200 requests
   Completed 400 requests
   Completed 600 requests
   Completed 800 requests
   Completed 1000 requests
   Completed 1200 requests
   Completed 1400 requests
   Completed 1600 requests
   Completed 1800 requests
   Completed 2000 requests
   Finished 2000 requests


   Server Software:        Apache/2.4.7
   Server Hostname:        localhost
   Server Port:            80

   Document Path:          /benchmark2/codeigniter/index.php/hello
   Document Length:        21 bytes

   Concurrency Level:      10
   Time taken for tests:   1.138 seconds
   Complete requests:      2000
   Failed requests:        0
   Total transferred:      416000 bytes
   HTML transferred:       42000 bytes
   Requests per second:    1757.96 [#/sec] (mean)
   Time per request:       5.688 [ms] (mean)
   Time per request:       0.569 [ms] (mean, across all concurrent requests)
   Transfer rate:          357.09 [Kbytes/sec] received

   Connection Times (ms)
                 min  mean[+/-sd] median   max
   Connect:        0    0   0.1      0       2
   Processing:     1    6   3.8      5      29
   Waiting:        0    5   3.8      4      29
   Total:          1    6   3.8      5      31
   
   Percentage of the requests served within a certain time (ms)
     50%      5
     66%      7
     75%      8
     80%      9
     90%     11
     95%     13
     98%     16
     99%     17
    100%     31 (longest request)

BitPHP
~~~~~~

Código del controlador
----------------------

.. code-block:: php

   <?php

   use \BitPHP\Mvc\Load;

   class Hello {
      public function main() {
         Load::view('hello');
      }
   }

Resultado
---------

.. code::

   $ ab -n 2000 -c 10 http://localhost/benchmark2/bitphp/hello
    This is ApacheBench, Version 2.3 <$Revision: 1528965 $>
    Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
    Licensed to The Apache Software Foundation, http://www.apache.org/

    Benchmarking localhost (be patient)
    Completed 200 requests
    Completed 400 requests
    Completed 600 requests
    Completed 800 requests
    Completed 1000 requests
    Completed 1200 requests
    Completed 1400 requests
    Completed 1600 requests
    Completed 1800 requests
    Completed 2000 requests
    Finished 2000 requests


    Server Software:        Apache/2.4.7
    Server Hostname:        localhost
    Server Port:            80

    Document Path:          /benchmark2/bitphp/hello
    Document Length:        21 bytes

    Concurrency Level:      10
    Time taken for tests:   0.568 seconds
    Complete requests:      2000
    Failed requests:        0
    Total transferred:      416000 bytes
    HTML transferred:       42000 bytes
    Requests per second:    3520.17 [#/sec] (mean)
    Time per request:       2.841 [ms] (mean)
    Time per request:       0.284 [ms] (mean, across all concurrent requests)
    Transfer rate:          715.03 [Kbytes/sec] received

    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        0    0   0.1      0       1
    Processing:     0    3   1.9      2      19
    Waiting:        0    3   1.8      2      16
    Total:          1    3   1.9      2      19

    Percentage of the requests served within a certain time (ms)
      50%      2
      66%      3
      75%      4
      80%      4
      90%      5
      95%      6
      98%      8
      99%      9
    100%     19 (longest request)
