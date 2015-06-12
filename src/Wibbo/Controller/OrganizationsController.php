<?php

namespace Wibbo\Controller;

use Symfony\Component\HttpFoundation\Request;
use Wibbo\Repository\OrganizationRepository;


class OrganizationsController {
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function build()
    {
        $controller = $this->app['controllers_factory'];

        $controller->get('/', function(Request $request) {
            $organizationRepository = new OrganizationRepository($this->app['db']);
            $organizations = $organizationRepository->getAll();
            return $this->app->json($organizations);
        });

        return $controller;
    }
}