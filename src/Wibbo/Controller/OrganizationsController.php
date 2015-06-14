<?php

namespace Wibbo\Controller;

use Symfony\Component\HttpFoundation\Request;
use Wibbo\Repository\IncidentRepository;
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

        $controller->get('/{organizationId}/incidents/now', function($organizationId) {
            $incidentRepository = new IncidentRepository($this->app['db']);
            $incidents = $incidentRepository->getAllActiveNow($organizationId);
            return $this->app->json($incidents);
        });

        $controller->get('/{organizationId}/stats', function($organizationId) {
            $incidentRepository = new IncidentRepository($this->app['db']);
            $average = $incidentRepository->getAverageIncidentDurationInMinutes($organizationId);
            $response = ['averageIncidentDuration' => $average];
            return $this->app->json($response);
        });

        return $controller;
    }
}