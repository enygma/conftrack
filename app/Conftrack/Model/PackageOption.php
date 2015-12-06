<?php

namespace Conftrack\Model;

class PackageOption extends \Modler\Model\Mysql
{
	protected $tableName = 'package_option';

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
    'optionId' => [
			'description' => 'Option ID',
			'column' => 'option_id',
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
