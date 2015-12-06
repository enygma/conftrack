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
		return [];
	}
	public function getGroups()
	{
		return [];
	}
	public function isAuthed()
	{
		return ($this->userData !== null && isset($this->userData['id']));
	}
}
