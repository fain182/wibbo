<?php

namespace Wibbo\Repository;

use Wibbo\Entity\Incident;

class IncidentRepository
{
    private $db;

    const AVERAGE_INCIDENT_DURATION_DEFAULT = "15";

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
        $incidents = array_map(
          function($row) { return Incident::fromRow($row); },
          $rows
        );
        return $incidents;
    }

    public function update($incidentId, $fields)
    {
        $updatedRows = $this->db->update('incidents', $fields, ['id'=>$incidentId]);
        return $updatedRows == 1;
    }


    public function getAverageIncidentDurationInMinutes($organizationId)
    {
        $rows = $this->db->fetchAll(
          'SELECT FLOOR(EXTRACT(epoch FROM avg(finish - start))/60) as avg_minutes_duration
           FROM incidents
           WHERE organization_id = ? and finish is not null
           GROUP BY organization_id', [$organizationId]);
        if (count($rows) == 0) {
            return self::AVERAGE_INCIDENT_DURATION_DEFAULT;
        }
        return $rows[0]['avg_minutes_duration'];
    }

}
