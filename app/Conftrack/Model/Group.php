<?php

namespace Conftrack\Model;

class Group extends \Modler\Model\Mysql
{
	protected $tableName = 'groups';

	protected $properties = [
		'id' => [
			'description' => 'ID',
			'column' => 'id'
		],
		'name' => [
			'description' => 'Event Name',
			'column' => 'name',
			'required' => true
		],
    'key' => [
			'description' => 'Key',
			'column' => 'group_key',
			'required' => true
		],
    'description' => [
			'description' => 'Description',
			'column' => 'description',
			'required' => true
		],
    'created' => [
      'name' => 'Create Date',
      'description' => 'Create Date',
      'column' => 'created'
    ],
    'updated' => [
      'name' => 'Update Date',
      'description' => 'Update Date',
      'column' => 'updated'
    ]
  ];
}
