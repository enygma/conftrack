<?php

namespace Conftrack\Model;

class UserGroup extends \Modler\Model\Mysql
{
	protected $tableName = 'user_groups';

	protected $properties = [
		'id' => [
			'description' => 'ID',
			'column' => 'id'
		],
		'groupId' => [
			'description' => 'Group ID',
			'column' => 'group_id',
			'required' => true
		],
    'userId' => [
			'description' => 'User ID',
			'column' => 'user_id',
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
