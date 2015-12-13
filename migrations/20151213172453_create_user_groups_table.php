<?php

use Phinx\Migration\AbstractMigration;

class CreateUserGroupsTable extends AbstractMigration
{
  public function up()
  {
      $packageOption = $this->table('user_groups');
      $packageOption
        ->addColumn('user_id', 'integer')
        ->addColumn('group_id', 'integer')
        ->addColumn('created', 'datetime', array('default' => null))
        ->addColumn('updated', 'datetime', array('default' => null))
        ->addIndex(array('user_id', 'group_id'), array('unique' => true))
        ->save();
  }
  public function down()
  {
      $this->dropTable('user_groups');
  }
}
