<?php

namespace Wibbo\Controller;

use Symfony\Component\HttpFoundation\Request;
use Wibbo\Entity\Organization;
use Wibbo\Repository\OrganizationRepository;

class AdminController
{
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function build()
    {
        $controller = $this->app['controllers_factory'];

        $controller->get('/', function () {
            return $this->app['twig']->render('admin/index.twig');
        });

        $controller->post('/organizations', function(Request $request) {
            $organizationRepository = new OrganizationRepository($this->app['db']);
            $organizationRepository->add(new Organization($request->request->get('name')));
            return "Organization added.";
        });

        return $controller;
    }

}
