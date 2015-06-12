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
        $admin = $this->app['controllers_factory'];
        $admin->get('/', function () {
            return $this->app['twig']->render('admin/index.twig');
        });

        $admin->post('/organizations', function(Request $request) {
            $organizations = new OrganizationRepository($this->app['db']);
            $organizations->add(new Organization($request->request->get('name')));
            return "Organization added.";
        });

        return $admin;
    }

}
