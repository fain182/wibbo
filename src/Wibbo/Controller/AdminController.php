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
            $organizationRepository = new OrganizationRepository($this->app['db']);
            $organizationRepository->add(new Organization($request->request->get('name')));
            return "Organization added.";
        });

        $admin->get('/organizations', function(Request $request) {
            $organizationRepository = new OrganizationRepository($this->app['db']);
            $organizations = $organizationRepository->getAll();
            return $this->app->json($organizations);
        /*    $serializedOrganizations = $this->app['serializer']->serialize($organizations, 'json');
            return new JsonResponse($serializedOrganizations, 200, array(
              "Content-Type" => $this->app['request']->getMimeType($format)
            ));
            return "Organization added."; */
        });

        return $admin;
    }

}
