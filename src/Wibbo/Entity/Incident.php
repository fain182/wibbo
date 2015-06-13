<?php

namespace Wibbo\Entity;

class Incident
{

    public $organizationId;
    public $description;
    public $start;

    public function __construct($organizationId, $description, \DateTime $start = null)
    {
        $this->organizationId = $organizationId;
        $this->description = $description;
        if ($start){
            $this->start = $start;
        } else {
            $this->start = new \DateTime();
        }
    }

    public static function fromRow($row)
    {
        return new Incident($row['organization_id'], $row['description'], new \DateTime($row['start']));
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStartTime()
    {
        return $this->start;
    }

    public function getOrganizationId()
    {
        return $this->organizationId;
    }
}
