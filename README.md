# BitPHP Devel

Aún algunos convenios por acordar:

- Cache habilitado por defecto.
- Vida por defecto del cache (5 mins por ahora).
- Nombre para el controlador principal, por ahora "Main".
- Nombre para la acción principal del controlador, por ahora "__index()".
- Los controladores no pertenecen a ningun espacio de nombres.
- Los modelos de la aplicacion deben pertenecer al espacio de nombres "App\Models".


```php
<?php
   
   use \Bitphp\Modules\Layout\Medusa;
   
   class MyController {
        public function __construct() {
            $this->medusa = new Medusa();
        }
        public function __index() {
            $this->medusa
                 ->load('foo_template')
                 ->with([
                    'name' => 'world'
                 ])
                 ->draw();
        }
   }
```

```html
    <html>
        <head>
            <title>Foo title</title>
            :css bootstrap
        </head>
        <body>
            :require another_sub_template
            <div class="jumbotron">
                <div class="container">
                    <h4>Hola {{ $name }}</h4>
                    :require another_sub_template [
                        'and_some' => 'params'
                    ]
                </div>
            </div>
        </body>
    </html>
```

# New Features

- **PSR-4: Autocarga de clases**
- **Nuevo y mejorado motor de plantillas**
- **Integracion de Composser (aún en eso xD)**
- **Sistema de cache**
- **Menos configuración para poder andar (de hecho ya no depende forsozamente del archivo de configuración)**