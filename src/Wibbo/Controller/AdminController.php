<?php

namespace Wibbo\Controller;

class AdminController
{
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function build()
    {
        $admin = $this->app['controllers_factory'];
        $admin->get('/', function () {
            return 'Admin';
        });
        return $admin;
    }
}
