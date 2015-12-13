<?php

use Phinx\Migration\AbstractMigration;

class CreateSponsorFilesTable extends AbstractMigration
{
  public function up()
  {
      $packageOption = $this->table('sponsor_files');
      $packageOption
        ->addColumn('sponsor_id', 'integer')
        ->addColumn('file_id', 'string')
        ->addColumn('created', 'datetime', array('default' => null))
        ->addColumn('updated', 'datetime', array('default' => null))
        ->addIndex(array('sponsor_id', 'file_id'), array('unique' => true))
        ->save();
  }
  public function down()
  {
      $this->dropTable('sponsor_files');
  }
}
