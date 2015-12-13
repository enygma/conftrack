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
    'files' => [
      'type' => 'relation',
      'description' => 'Files',
      'relation' => [
        'model' => '\\Conftrack\\Collection\\Files',
        'method' => 'findBySponsorId',
        'local' => 'id'
      ]
    ],
  ];

  public function handleUpload($fileData)
  {
    $uploadPath = APP_PATH.'/upload/sponsor/'.$this->id;
    if (realpath($uploadPath) === false) {
      mkdir($uploadPath);
    }
    $hash = sha1(file_get_contents($fileData['tmp_name']));
    move_uploaded_file($fileData['tmp_name'], $uploadPath.'/'.$hash);

    // Now save a record for it in files
    $file = new \Conftrack\Model\File($this->getDb());
    $file->load([
      'name' => $fileData['name'],
      'hash' => $hash
    ]);
    $file->save();

    $sponsorFile = new \Conftrack\Model\SponsorFile($this->getDb());
    $sponsorFile->load([
      'sponsor_id' => $this->id,
      'file_id' => $file->id
    ]);
    $sponsorFile->save();
  }

  /**
   * Cross-reference the file ID with the sponsor ID
   */
  public function findByFileId($fileId)
  {
    $sponsorFile = new \Conftrack\Model\SponsorFile($this->getDb());
    $sponsorFile->find([
      'file_id' => $fileId
    ]);
    $this->load($sponsorFile->sponsor->toArray());
  }
}
