<?php

namespace Wibbo\Entity;

class Organization
{
    public $id;
    public $name;

    public function __construct($name, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public static function fromRow($row)
    {
       return new Organization($row['name'], $row['id']);
    }
}
