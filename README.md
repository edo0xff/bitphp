[![Code Climate](https://codeclimate.com/github/0oeduardoo0/BitPHP/badges/gpa.svg)](https://codeclimate.com/github/0oeduardoo0/BitPHP)

# BitPHP

BitPHP es un framework para el desarrollo web, orientado al programador aprendiz, sabemos lo difícil y tedioso qué puede llegar a ser el embarcarte con una nueva herramienta de desarrollo. Fue a raíz de esto qué surge BitPHP, para qué rapidamente puedas comenzar a crear fantasticas aplicaciones :D

# Filosofía

> “Grandes problemas, pequeñas soluciones”

Creemos firmemente qué no importa la complejidad del problema o necesidad qué debas resolver, todo puede, y debe, tener una solución sencilla y elegante.

```php
<?php
   $app = $bitphp->loadMicroServer();
   
   $app->route('/say/hello', function() use ($app){
      echo "Hola mundo!";
   });
   
   $app->run();
```
```php
<?php
   $app = $bitphp->loadApiServer();
   
   $app->get('/say/hello', function() use ($app){
      $app->response([
           'status' => $app->getStatusMessage()
         , 'result' => 'Hola mundo!'
      ]);
   });
   
   $app->run();
```
```php
<?php
   $server = $bitphp->loadSocketServer();
   
   $server->on('connect', function($client) use ($server){
      $client->send("Hola mundo!");
   });
   
   $server->run();
```
```php
<?php
   class Say {
      public function hello() {
         echo "Hola mundo!";
      }
   }
```
# Características

- **Soporte a diversas arquitecturas:** (MVC/HMVC/Micro MVC/RestFUL Service/Sockets).
- **Velocidad: la ejecución de bitphp** es realmente rápida.
- **Ligereza:** su núcleo tiene apenas unos cuantos KBytes
- **Minimalismo:** nos esforzamos en lograr qué las aplicaciones puedan tener un código limpio y fácil de entender.
- **Naturaleza modular:** se puede extender su funcionalidad fácilmente a través de la creación de módulos.

# Enlaces

- [Website](http://bitphp.root404.com)
- [Descarga](http://bitphp.root404.com/downloads)
- [Documentación](http://bitphp.root404.com/docs)
