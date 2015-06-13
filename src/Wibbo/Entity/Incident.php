<?php

namespace Wibbo\Entity;

class Incident
{

    private $organizationId;
    private $description;
    private $start;

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
