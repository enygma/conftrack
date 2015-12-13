<?php

use Phinx\Migration\AbstractMigration;

class CreateFilesTable extends AbstractMigration
{
  public function up()
  {
      $packageOption = $this->table('files');
      $packageOption
        ->addColumn('name', 'string')
        ->addColumn('hash', 'string')
        ->addColumn('created', 'datetime', array('default' => null))
        ->addColumn('updated', 'datetime', array('default' => null))
        ->addIndex(array('hash'), array('unique' => true))
        ->save();
  }
  public function down()
  {
      $this->dropTable('files');
  }
}
