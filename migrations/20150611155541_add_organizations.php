<?php

use Phinx\Migration\AbstractMigration;

class AddOrganizations extends AbstractMigration
{
    public function change()
    {
        $this->table('organizations')
            ->addColumn('name', 'string')
            ->create();
    }
}