<?php

namespace Conftrack\Model;

class Event extends \Modler\Model\Mysql
{
	protected $tableName = 'events';

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
    'startDate' => [
			'description' => 'Event Start Date',
			'column' => 'start_date',
			'required' => true
		],
    'endDate' => [
			'description' => 'Event End Date',
			'column' => 'end_date',
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
    'sponsors' => [
      'type' => 'relation',
      'description' => 'Sponsors',
      'relation' => [
        'model' => '\\Conftrack\\Collection\\Sponsors',
        'method' => 'findByEventId',
        'local' => 'id'
      ]
    ]
  ];
}
