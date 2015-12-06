<?php

use Phinx\Migration\AbstractMigration;

class CreatePackageTable extends AbstractMigration
{
  public function up()
  {
      $packages = $this->table('packages');
      $packages
        ->addColumn('name', 'string')
        ->addColumn('cost', 'integer')
        ->addColumn('description', 'text')
        ->addColumn('max', 'integer')
        ->addColumn('created', 'datetime', array('default' => null))
        ->addColumn('updated', 'datetime', array('default' => null))
        ->addIndex(array('name'))
        ->save();
  }
  public function down()
  {
      $this->dropTable('packages');
  }
}
