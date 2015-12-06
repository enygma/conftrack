<?php

namespace Conftrack\Model;

class Package extends \Modler\Model\Mysql
{
	protected $tableName = 'packages';

	protected $properties = [
		'id' => [
			'description' => 'ID',
			'column' => 'id'
		],
		'name' => [
			'description' => 'Package Name',
			'column' => 'name',
			'required' => true
		],
    'cost' => [
			'description' => 'Cost',
			'column' => 'cost',
			'required' => true
		],
    'description' => [
			'description' => 'Description',
			'column' => 'logo',
			'required' => true
		],
    'maxAvailable' => [
			'description' => 'Maximum Number Available',
			'column' => 'max',
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
