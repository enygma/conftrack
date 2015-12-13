<?php

namespace Conftrack\Model;

class User extends \Modler\Model\Mysql
{
	protected $tableName = 'users';

	protected $properties = [
		'id' => [
			'description' => 'ID',
			'column' => 'id'
		],
		'password' => [
			'description' => 'Password',
			'column' => 'password',
			'required' => true,
			'guard' => true
		],
		'fullName' => [
			'description' => 'Full Name',
			'column' => 'name',
			'required' => true
		],
		'username' => [
			'description' => 'Username',
			'column' => 'username',
			'required' => true
		],
		'email' => [
			'description' => 'Email Address',
			'column' => 'email',
			'required' => true
		],
		'status' => [
			'description' => 'Status',
			'column' => 'status',
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
        'method' => 'findByUserId',
        'local' => 'id'
      ]
    ],
    'groups' => [
      'type' => 'relation',
      'description' => 'Groups',
      'relation' => [
        'model' => '\\Conftrack\\Collection\\Groups',
        'method' => 'findByUserId',
        'local' => 'id'
      ]
    ]
	];

	public function validateEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL) !== $email) {
			$this->setMessage('email', 'Invalid email - wrong format');
			return false;
		}

		return true;
	}

  public function validateUsername($username)
  {
    // Be sure the address is unique
    if ($this->isUsernameUnique($username) === false) {
      $this->setMessage('username', 'Username already exists!');
      return false;
    }

    return true;
  }

	public function save()
	{
		$password = $this->getValue('password');

		if (password_needs_rehash($password, PASSWORD_DEFAULT)) {
			$password = password_hash($password, PASSWORD_DEFAULT);
		}
		$this->setValue('password', $password);

		parent::save();
	}

  public function disable()
  {
    $this->status = 'inactive';
    $this->save();
  }
  public function enable()
  {
    $this->status = 'active';
    $this->save();
  }
  public function isActive()
  {
    return ($this->status == 'active');
  }

}
