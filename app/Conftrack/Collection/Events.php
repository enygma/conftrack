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

  public function findBySponsorId($sponsorId)
  {
    $sql = 'select e.* from events e, sponsor_event se'
      .' where se.event_id = e.id and se.sponsor_id = :sponsorId';

    $results = $this->fetch($sql, ['sponsorId' => $sponsorId]);

		foreach ($results as $result) {
			$event = new \Conftrack\Model\Event($this->getDb());
			$event->load($result, false);
			$this->add($event);
		}
  }
}
