<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/', function () use ($app) {
    return 'wibbo';
});


$adminController = new \Wibbo\Controller\AdminController($app);
$app->mount('/admin', $adminController->build());

$app->run();