<?php

namespace Conftrack\Collection;

class Users extends \Modler\Collection\Mysql
{
	public function findAll($limit = null)
	{
    $sql = 'select * from users';
    $results = $this->fetch($sql);

		foreach ($results as $result) {
			$user = new \Conftrack\Model\User($this->getDb());
			$user->load($result, false);
			$this->add($user);
		}
  }

  public function findBySponsorId($sponsorId)
  {
    $sql = 'select u.* from users u, sponsor_user su'
      .' where su.sponsor_id = :sponsorId and u.id = su.user_id';

    $results = $this->fetch($sql, ['sponsorId' => $sponsorId]);

		foreach ($results as $result) {
			$user = new \Conftrack\Model\User($this->getDb());
			$user->load($result, false);
			$this->add($user);
		}
  }
}
