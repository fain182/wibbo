<?php

namespace Wibbo\Repository;

use Wibbo\Entity\Incident;

class IncidentRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function add(Incident $incident)
    {
        $startFormatted = $incident->getStartTime()->format('m-d-Y H:i:s');
        $row = ['organization_id' => $incident->getOrganizationId(), 'description' => $incident->getDescription(), 'start' => $startFormatted];
        $insertedRows = $this->db->insert('incidents', $row);
        return $insertedRows == 1;
    }
}
