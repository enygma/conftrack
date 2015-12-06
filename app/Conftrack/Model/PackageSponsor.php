<?php

namespace Conftrack\Model;

class PackageSponsor extends \Modler\Model\Mysql
{
	protected $tableName = 'package_sponsor';

	protected $properties = [
		'id' => [
			'description' => 'ID',
			'column' => 'id'
		],
		'packageId' => [
			'description' => 'Package ID',
			'column' => 'package_id',
			'required' => true
		],
    'sponsorId' => [
			'description' => 'Sponsor ID',
			'column' => 'sponsor_id',
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
