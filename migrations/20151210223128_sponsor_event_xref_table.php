<?php

use Phinx\Migration\AbstractMigration;

class SponsorEventXrefTable extends AbstractMigration
{
  public function up()
  {
      $packageOption = $this->table('sponsor_event');
      $packageOption
        ->addColumn('sponsor_id', 'integer')
        ->addColumn('event_id', 'integer')
        ->addColumn('created', 'datetime', array('default' => null))
        ->addColumn('updated', 'datetime', array('default' => null))
        ->addIndex(array('sponsor_id', 'event_id'), array('unique' => true))
        ->save();
  }
  public function down()
  {
      $this->dropTable('sponsor_event');
  }
}
