<?php

use Phinx\Migration\AbstractMigration;

class CreateOptionTable extends AbstractMigration
{
  public function up()
  {
      $options = $this->table('options');
      $options
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
      $this->dropTable('options');
  }
}
