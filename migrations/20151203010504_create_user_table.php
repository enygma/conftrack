<?php

use Phinx\Migration\AbstractMigration;

class CreateUserTable extends AbstractMigration
{
    public function up()
    {
        $users = $this->table('users');
        $users
          ->addColumn('username', 'string')
          ->addColumn('email', 'string')
          ->addColumn('name', 'string')
          ->addColumn('password', 'string')
          ->addColumn('status', 'string')
          ->addColumn('created', 'datetime', array('default' => null))
          ->addColumn('updated', 'datetime', array('default' => null))
          ->addIndex(array('username'), array('unique' => true))
          ->save();
    }
    public function down()
    {
        $this->dropTable('users');
    }
}
