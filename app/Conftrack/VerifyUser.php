<?php

namespace Conftrack;

class VerifyUser implements \Psecio\Verify\Subject
{
  private $user;

  public function __construct($user)
  {
      $this->user = $user;
  }

  public function getIdentifier()
  {
    return $this->user->username;
  }

  public function getCredential()
  {
    return $this->user->password;
  }
}
