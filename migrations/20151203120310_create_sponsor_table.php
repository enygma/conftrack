<?php

use Phinx\Migration\AbstractMigration;

class CreateSponsorTable extends AbstractMigration
{
  public function up()
  {
      $sponsors = $this->table('sponsors');
      $sponsors
        ->addColumn('name', 'string')
        ->addColumn('logo', 'string')
        ->addColumn('description', 'text')
        ->addColumn('created', 'datetime', array('default' => null))
        ->addColumn('updated', 'datetime', array('default' => null))
        ->addIndex(array('name'))
        ->save();
  }
  public function down()
  {
      $this->dropTable('sponsors');
  }
}
