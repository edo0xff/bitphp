<?php 
    
    require 'core/bit.php';
    require 'core/modules/Template.php';

    $app = $bitphp->loadMicroServer();

    $app->route('/', function() {
        Template::quickDraw('welcome', [
            'dir' => realpath(__DIR__ . '/cli')
        ]);
    });

    $app->run();