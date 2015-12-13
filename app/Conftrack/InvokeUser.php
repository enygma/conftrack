<?php

namespace Conftrack;

class InvokeUser implements \Psecio\Invoke\UserInterface
{
	private $userData = [];

	public function __construct($userData)
	{
		$this->userData = $userData;
	}

	public function getPermissions()
	{
    $permissions = $this->userData->permissions;
    $return = [];

    foreach ($permissions as $group) {
      $return[] = $permissions->key;
    }
    return $return;
	}
	public function getGroups()
	{
    $groups = $this->userData->groups;
    $return = [];

    foreach ($groups as $group) {
      $return[] = $group->key;
    }
    return $return;
	}
	public function isAuthed()
	{
		return ($this->userData !== null && $this->userData->id !== null);
	}
}
