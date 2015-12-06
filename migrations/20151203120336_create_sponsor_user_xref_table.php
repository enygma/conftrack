<?php

use Phinx\Migration\AbstractMigration;

class CreateSponsorUserXrefTable extends AbstractMigration
{
  public function up()
  {
      $packageOption = $this->table('sponsor_user');
      $packageOption
        ->addColumn('sponsor_id', 'integer')
        ->addColumn('user_id', 'integer')
        ->addColumn('created', 'datetime', array('default' => null))
        ->addColumn('updated', 'datetime', array('default' => null))
        ->addIndex(array('sponsor_id', 'user_id'), array('unique' => true))
        ->save();
  }
  public function down()
  {
      $this->dropTable('sponsor_user');
  }
}
