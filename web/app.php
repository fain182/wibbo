<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

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

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
  'db.options' => Wibbo\Db\DbConfiguration::generate(getenv("DATABASE_URL")),
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/../views',
));

$organizationController = new \Wibbo\Controller\OrganizationsController($app);
$app->mount('/organizations', $organizationController->build());

$adminController = new \Wibbo\Controller\AdminController($app);
$app->mount('/admin', $adminController->build());

$frontendController = new \Wibbo\Controller\FrontendController($app);
$app->mount('/', $frontendController->build());

return $app;