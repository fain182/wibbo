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
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $row['start'], new \DateTimeZone("UTC"));
        return new Incident($row['organization_id'], $row['description'], $date, $row['id']);
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
