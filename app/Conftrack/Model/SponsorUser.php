<?php

namespace Conftrack\Model;

class SponsorUser extends \Modler\Model\Mysql
{
	protected $tableName = 'sponsor_user';

	protected $properties = [
		'id' => [
			'description' => 'ID',
			'column' => 'id'
		],
		'sponsorId' => [
			'description' => 'Sponsor ID',
			'column' => 'sponsor_id',
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
