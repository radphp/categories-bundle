<?php

use Phinx\Migration\AbstractMigration;

class AddResources extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     */
    public function change()
    {
        $this->execute('INSERT INTO "resources" ("name", "title", "description")
VALUES (\'categories.manage\', \'Manage Categories\', \'List, add, edit, delete categories\')');
    }
}
