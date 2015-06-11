<?php

namespace Wibbo\Repository;

use Wibbo\Entity\Organization;

class OrganizationRepository
{
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
}
