<?php

namespace Wibbo\Entity;

class Organization
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public static function fromRow($row)
    {
       return new Organization($row['name']);
    }
}
