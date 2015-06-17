<?php

namespace Wibbo\FunctionalTest;

class OrganizationTest extends WibboTestCase {

    public function testWithoutOrganizations()
    {
        $this->client->request('GET', '/organizations/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals([], json_decode($this->client->getResponse()->getContent()));
    }

    public function testAddingOrganizations()
    {
        $this->requestAuthenticated('POST', '/admin/organizations', ['name' => 'abc']);

        $organizations = $this->getAllOrganizations();

        $this->assertEquals(1, count($organizations));
        $this->assertEquals('abc', $organizations[0]['name']);
    }

    public function testDeleteOrganizations()
    {
        $this->requestAuthenticated('POST', '/admin/organizations', ['name' => 'abc']);

        $organizations = $this->getAllOrganizations();
        $id = $organizations[0]['id'];
        $this->requestAuthenticated('DELETE', '/admin/organizations/'.$id, ['name' => 'abc']);

        $organizations = $this->getAllOrganizations();
        $this->assertEquals(0, count($organizations));

    }

}
