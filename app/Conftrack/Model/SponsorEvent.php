<?php

namespace Conftrack\Model;

class SponsorEvent extends \Modler\Model\Mysql
{
	protected $tableName = 'sponsor_event';

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
    'eventId' => [
			'description' => 'Event ID',
			'column' => 'event_id',
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
