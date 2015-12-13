<?php

namespace Conftrack\Collection;

class Groups extends \Modler\Collection\Mysql
{
  public function findAll()
  {
    $sql = 'select * from groups';
    $results = $this->fetch($sql);

    foreach ($results as $result) {
			$group = new \Conftrack\Model\Group($this->getDb());
			$group->load($result, false);
			$this->add($group);
		}
  }

  public function findByUserId($userId)
  {
    $sql = 'select g.* from groups g, user_groups ug'
      .' where g.id = ug.group_id and ug.user_id = :userId';
    $results = $this->fetch($sql, ['userId' => $userId]);

    foreach ($results as $result) {
			$group = new \Conftrack\Model\Group($this->getDb());
			$group->load($result, false);
			$this->add($group);
		}
  }
}
