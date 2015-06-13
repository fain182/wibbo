<?php

use Phinx\Migration\AbstractMigration;

class AddIncidents extends AbstractMigration
{

    public function change()
    {
        $this->table('incidents')
          ->addColumn('organization_id', 'integer')
          ->addColumn('description', 'string')
          ->addColumn('start', 'timestamp')
          ->addColumn('end', 'timestamp', ['null'=>true])
          ->addForeignKey('organization_id', 'organizations', 'id', array('delete'=> 'CASCADE'))
          ->create();
    }

}