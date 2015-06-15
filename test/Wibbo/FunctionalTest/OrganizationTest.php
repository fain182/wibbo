<?php

namespace Wibbo\FunctionalTest;

class OrganizationTest extends WibboTestCase {

    public function testWithoutOrganizations()
    {
        $client = $this->createClient();
        $client->request('GET', '/organizations/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals([], json_decode($client->getResponse()->getContent()));
    }
    
}
