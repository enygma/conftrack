<?php

namespace Conftrack\Model;

class File extends \Modler\Model\Mysql
{
	protected $tableName = 'files';

	protected $properties = [
		'id' => [
			'description' => 'ID',
			'column' => 'id'
		],
		'name' => [
			'description' => 'File Name',
			'column' => 'name',
			'required' => true
		],
    'hash' => [
			'description' => 'Hash',
			'column' => 'hash',
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
    ],
		'sponsor' => [
      'type' => 'relation',
      'description' => 'Sponsor',
      'relation' => [
        'model' => '\\Conftrack\\Model\\Sponsor',
        'method' => 'findByFileId',
        'local' => 'id'
      ]
    ]
  ];
}
