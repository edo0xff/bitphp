<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->get('/hello/:name', function ($name) {
    echo "Hola $name!";
});

$app->run();
