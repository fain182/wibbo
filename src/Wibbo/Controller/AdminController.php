<?php

namespace Wibbo\Controller;

use Symfony\Component\HttpFoundation\Request;
use Wibbo\Entity\Incident;
use Wibbo\Entity\Organization;
use Wibbo\Repository\IncidentRepository;
use Wibbo\Repository\OrganizationRepository;

class AdminController
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function build()
    {
        $controller = $this->app['controllers_factory'];

        $controller->get('/', function () {
            return $this->app['twig']->render('admin.twig');
        });

        $controller->post('/organizations', function(Request $request) {
            $organizationRepository = new OrganizationRepository($this->app['db']);
            $organizationRepository->add(new Organization($request->request->get('name')));
            return "Organization added.";
        });

        $controller->delete('/organizations/{organizationId}', function($organizationId) {
            $organizationRepository = new OrganizationRepository($this->app['db']);
            $organizationRepository->deleteById($organizationId);
            return "Organization deleted.";
        });

        $controller->post('/organizations/{organizationId}/incidents', function($organizationId, Request $request) {
            $incidentRepository = new IncidentRepository($this->app['db']);
            $incidentRepository->add(new Incident($organizationId, $request->request->get('description')));
            return "Incident added.";
        });

        $controller->patch('/organizations/{organizationId}/incidents/{incidentId}', function($organizationId, $incidentId, Request $request) {
            $incidentRepository = new IncidentRepository($this->app['db']);
            $incidentRepository->update($incidentId, $request->request->all());
            return "Incident updated.";
        });

        return $controller;
    }

}
