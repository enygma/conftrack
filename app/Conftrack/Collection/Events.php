<?php

namespace Conftrack\Collection;

class Events extends \Modler\Collection\Mysql
{
	public function findAll($limit = null)
	{
    $sql = 'select * from events';
    $results = $this->fetch($sql);

		foreach ($results as $result) {
			$event = new \Conftrack\Model\Event($this->getDb());
			$event->load($result, false);
			$this->add($event);
		}
  }
}
