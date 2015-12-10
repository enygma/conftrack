<?php

namespace Conftrack\Collection;

class Sponsors extends \Modler\Collection\Mysql
{
  public function findAll()
  {
    $sql = 'select * from sponsors';
    $results = $this->fetch($sql);

    foreach ($results as $result) {
      $sponsor = new \Conftrack\Model\Sponsor($this->getDb());
      $sponsor->load($result);
      $this->add($sponsor);
    }
  }

  public function findByEventId($eventId)
  {
    $sql = 'select sp.* from sponsors sp, sponsor_event se'
      .' where sp.id = se.sponsor_id and se.event_id = :eventId';
    $results = $this->fetch($sql, ['eventId' => $eventId]);

    foreach ($results as $result) {
      $sponsor = new \Conftrack\Model\Sponsor($this->getDb());
      $sponsor->load($result);
      $this->add($sponsor);
    }
  }
}
