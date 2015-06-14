<?php

namespace Wibbo\Entity;

class Incident
{

    public $id;
    public $organizationId;
    public $description;
    public $start;

    public function __construct($organizationId, $description, \DateTime $start = null, $id = null)
    {
        $this->organizationId = $organizationId;
        $this->description = $description;
        if ($start){
            $this->start = $start->getTimestamp();
        } else {
            $this->start = time();
        }
        $this->id = $id;
    }

    public static function fromRow($row)
    {
        return new Incident($row['organization_id'], $row['description'], new \DateTime($row['start']), $row['id']);
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStartTime()
    {
        return new \DateTime("@$this->start");
    }

    public function getOrganizationId()
    {
        return $this->organizationId;
    }
}
