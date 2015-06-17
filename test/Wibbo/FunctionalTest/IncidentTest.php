<?php


namespace Wibbo\FunctionalTest;

class IncidentTest extends WibboTestCase
{
    private $organizationId;

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
        $this->addIncidentClosed(5);

        $this->client->request('GET', '/organizations/'.$this->organizationId.'/incidents/now');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $activeIncidents = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals(0, count($activeIncidents));
    }


    public function testAverageDurationWithoutIncident()
    {
        $this->client->request('GET', '/organizations/'.$this->organizationId.'/stats');
        $stats = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals(15, $stats->averageIncidentDuration);
    }

    public function testAverageDurationWithIncident()
    {
        $this->addIncidentClosed(8);
        $this->addIncidentClosed(12);

        $this->client->request('GET', '/organizations/'.$this->organizationId.'/stats');
        $stats = json_decode($this->client->getResponse()->getContent());
        $this->assertEquals(10, $stats->averageIncidentDuration);
    }

    protected function addIncidentClosed($inNMinutesFromNow)
    {
        $this->requestAuthenticated(
          'POST',
          '/admin/organizations/' . $this->organizationId . '/incidents',
          ['description' => 'fake problem 2']
        );

        $this->client->request('GET', '/organizations/' . $this->organizationId . '/incidents/now');
        $activeIncidentsBeforeClosing = json_decode($this->client->getResponse()->getContent());
        $incidentId = $activeIncidentsBeforeClosing[0]->id;

        $finishTimeInUtc = new \DateTime(null, new \DateTimeZone('UTC'));
        $finishTimeInUtc->add(new \DateInterval("PT".$inNMinutesFromNow."M"));
        $this->requestAuthenticated(
          'PATCH',
          '/admin/organizations/' . $this->organizationId . '/incidents/' . $incidentId,
          ['finish' => $finishTimeInUtc->format(\DateTime::ISO8601)]
        );
    }

}