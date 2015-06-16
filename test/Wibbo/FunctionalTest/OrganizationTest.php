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

    public function testAddingOrganizations()
    {
        $client = $this->createClient();
        $client->request('POST', '/admin/organizations/', ['name'=>'abc'], [], array('PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'foo'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('GET', '/organizations/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $result = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('abc', $result[0]['name']);
    }

}
