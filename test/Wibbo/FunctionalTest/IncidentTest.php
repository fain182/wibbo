<?php


namespace Wibbo\FunctionalTest;

class IncidentTest extends WibboTestCase {

    public function setUp()
    {
        parent::setUp();
        $this->requestAuthenticated('POST', '/admin/organizations', ['name' => 'test org']);
        $organizations = $this->getAllOrganizations($this->client);
        $this->organizationId = $organizations[0]['id'];
    }

    public function testWithoutIncidents()
    {
        $this->client->request('GET', '/organizations/'.$this->organizationId.'/incidents/now');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals([], json_decode($this->client->getResponse()->getContent()));
    }

    public function testWithIncidentsOpen()
    {
        $this->requestAuthenticated(
          'POST',
          '/admin/organizations/'.$this->organizationId.'/incidents',
          ['description' => 'fake problem']
        );
        $this->client->request('GET', '/organizations/'.$this->organizationId.'/incidents/now');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $activeIncidents = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals(1, count($activeIncidents));
    }

    public function testWithIncidentsClosed()
    {
        $this->requestAuthenticated(
          'POST',
          '/admin/organizations/'.$this->organizationId.'/incidents',
          ['description' => 'fake problem 2']
        );

        $this->client->request('GET', '/organizations/'.$this->organizationId.'/incidents/now');
        $activeIncidents = json_decode($this->client->getResponse()->getContent());
        $incidentId = $activeIncidents[0]->id;


        $this->requestAuthenticated(
          'PATCH',
          '/admin/organizations/'.$this->organizationId.'/incidents/'.$incidentId,
          ['finish' => '2015-06-17T16:02:46.070Z']
        );
        $this->client->request('GET', '/organizations/'.$this->organizationId.'/incidents/now');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $activeIncidents = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals(0, count($activeIncidents));
    }


}