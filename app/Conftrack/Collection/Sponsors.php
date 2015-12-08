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
}
