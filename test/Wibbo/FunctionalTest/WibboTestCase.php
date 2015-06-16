<?php

namespace Wibbo\FunctionalTest;


use Silex\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class WibboTestCase extends WebTestCase {

    protected $client;

    public function setUp()
    {
        parent::setUp();
        $this->app['db']->delete('organizations', array(1 => 1));
        $this->app['db']->delete('incidents', array(1 => 1));
    }

    public function createApplication()
    {
        $app = include __DIR__."/../../../web/app.php";
        $app->boot();
        return $app;
    }

}