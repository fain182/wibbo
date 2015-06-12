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

$defaultDbConfiguration = array(
  'driver'    => 'pdo_pgsql',
  'host'      => 'localhost',
  'dbname'    => 'wibbo',
  'user'      => 'local',
  'password'  => 'local',
  'charset'   => 'utf8',
);

$dbUrl = getenv("DATABASE_URL");

$isOnHeroku = !empty($dbUrl);

if ($isOnHeroku) {
    $dbUrl = parse_url($dbUrl);
    $defaultDbConfiguration['host'] = $dbUrl['host'];
    $defaultDbConfiguration['user'] = $dbUrl['user'];
    $defaultDbConfiguration['password'] = $dbUrl['pass'];
    $defaultDbConfiguration['dbname'] = substr($dbUrl['path'],1);
}
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
  'db.options' => $defaultDbConfiguration,
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\SerializerServiceProvider());


$app->get('/', function () use ($app) {
    return 'wibbo';
});


$organizationController = new \Wibbo\Controller\OrganizationsController($app);
$app->mount('/organizations', $organizationController->build());

$adminController = new \Wibbo\Controller\AdminController($app);
$app->mount('/admin', $adminController->build());

return $app;