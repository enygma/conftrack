<?php

namespace Conftrack\Model;

class Sponsor extends \Modler\Model\Mysql
{
	protected $tableName = 'sponsors';

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
    'description' => [
			'description' => 'Description',
			'column' => 'description',
			'required' => true
		],
    'logo' => [
			'description' => 'Sponsor Logo Image',
			'column' => 'logo'
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
    ],
    'users' => [
      'type' => 'relation',
      'description' => 'Team Members',
      'relation' => [
        'model' => '\\Conftrack\\Collection\\Users',
        'method' => 'findBySponsorId',
        'local' => 'id'
      ]
    ],
  ];
}
