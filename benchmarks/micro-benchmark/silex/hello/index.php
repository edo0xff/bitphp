<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->get('/{name}', function( $name ) {
    return "Hola $name!";
});

$app->run();
