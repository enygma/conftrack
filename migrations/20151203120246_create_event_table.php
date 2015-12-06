<?php

use Phinx\Migration\AbstractMigration;

class CreateEventTable extends AbstractMigration
{
  public function up()
  {
      $events = $this->table('events');
      $events
        ->addColumn('name', 'string')
        ->addColumn('start_date', 'datetime')
        ->addColumn('end_date', 'datetime')
        ->addColumn('created', 'datetime', array('default' => null))
        ->addColumn('updated', 'datetime', array('default' => null))
        ->addIndex(array('name'), array('unique' => true))
        ->save();
  }
  public function down()
  {
      $this->dropTable('events');
  }
}
