<?php

use Phinx\Migration\AbstractMigration;

class CreatePackageOptionXrefTable extends AbstractMigration
{
  public function up()
  {
      $packageOption = $this->table('package_option');
      $packageOption
        ->addColumn('package_id', 'integer')
        ->addColumn('option_id', 'integer')
        ->addColumn('created', 'datetime', array('default' => null))
        ->addColumn('updated', 'datetime', array('default' => null))
        ->addIndex(array('package_id', 'option_id'), array('unique' => true))
        ->save();
  }
  public function down()
  {
      $this->dropTable('package_option');
  }
}
