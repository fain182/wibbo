<?php


namespace Wibbo\Controller;


class FrontendController {
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function build()
    {
        $controller = $this->app['controllers_factory'];

        $controller->get('/', function () {
            return $this->app['twig']->render('homepage.twig');
        });

        return $controller;
    }

}