<?php

namespace Conftrack\Model;

class SponsorFile extends \Modler\Model\Mysql
{
	protected $tableName = 'sponsor_files';

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
    'fileId' => [
			'description' => 'File ID',
			'column' => 'file_id',
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
        'method' => 'findById',
        'local' => 'sponsorId'
      ]
    ]
  ];
}
