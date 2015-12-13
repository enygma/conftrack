<?php

use Phinx\Migration\AbstractMigration;

class CreateGroupsTable extends AbstractMigration
{
  public function up()
  {
      $packageOption = $this->table('groups');
      $packageOption
        ->addColumn('name', 'string')
        ->addColumn('group_key', 'string')
        ->addColumn('description', 'text')
        ->addColumn('created', 'datetime', array('default' => null))
        ->addColumn('updated', 'datetime', array('default' => null))
        ->addIndex(array('name'), array('unique' => true))
        ->save();
  }
  public function down()
  {
      $this->dropTable('groups');
  }
}
