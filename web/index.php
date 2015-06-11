<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' =>  array(
        'admin' => array(
            'pattern' => '^/admin',
            'http' => true,
            'users' => array(
                'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
            ),
        ),
    )
));


$app->get('/', function () use ($app) {
    return 'wibbo';
});


$adminController = new \Wibbo\Controller\AdminController($app);
$app->mount('/admin', $adminController->build());



$app->run();