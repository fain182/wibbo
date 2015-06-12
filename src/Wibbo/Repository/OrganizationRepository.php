<?php

namespace Wibbo\Repository;

use Wibbo\Entity\Organization;

class OrganizationRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function add(Organization $organization)
    {
        $row = ['name' => $organization->getName()];
        $insertedRows = $this->db->insert('organizations', $row);
        return $insertedRows == 1;
    }

    public function getAll()
    {
        $rows = $this->db->fetchAll('SELECT * FROM organizations');
        $organizations = array_map(
          function($row) { return Organization::fromRow($row); },
          $rows
        );
        return $organizations;
    }
}
