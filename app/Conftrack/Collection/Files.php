<?php

namespace Conftrack\Collection;

class Files extends \Modler\Collection\Mysql
{
  public function findBySponsorId($sponsorId)
  {
    $sql = 'select f.* from files f, sponsor_files sf'
      .' where f.id = sf.file_id and sf.sponsor_id = :sponsorId';
    $results = $this->fetch($sql, ['sponsorId' => $sponsorId]);

		foreach ($results as $result) {
			$file = new \Conftrack\Model\File($this->getDb());
			$file->load($result, false);
			$this->add($file);
		}
  }
}
