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

    public function getAllActiveNow($organizationId)
    {
        $rows = $this->db->fetchAll('SELECT * FROM incidents where organization_id = ? and finish is null', [$organizationId]);
        $organizations = array_map(
          function($row) { return Incident::fromRow($row); },
          $rows
        );
        return $organizations;
    }

    public function update($incidentId, $fields)
    {
        $updatedRows = $this->db->update('incidents', $fields, ['id'=>$incidentId]);
        return $updatedRows == 1;
    }

}
