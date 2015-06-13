<?php

use Phinx\Migration\AbstractMigration;

class RenameEndColumn extends AbstractMigration
{

    public function change()
    {
        $this->table('incidents')
          ->renameColumn('end', 'finish')
          ->update();
    }

}