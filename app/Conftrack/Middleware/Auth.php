<?php

namespace Conftrack\Middleware;
use Psecio\Invoke\Enforcer;

class Auth
{
	public function __invoke($request, $response, $next)
  {
  	$session = $this->getSession();
  	$user = $session->getSegment('default')->get('user');

    // Load up Invoke and make the checks
    $enforcer = new Enforcer(__DIR__.'/../../config/routes.yml');
    $allowed = $enforcer->isAuthorized(
        new \Conftrack\InvokeUser($user),
        new \Psecio\Invoke\Resource()
    );

    if ($allowed === false) {
        // redirect! not allowed
        return $response->withRedirect('/error');
    }

    // Allowed, pass on through
    $response = $next($request, $response);
    return $response;
  }

  private function getSession()
  {
  	$sessionFactory = new \Aura\Session\SessionFactory;
  	return $sessionFactory->newInstance([]);
  }
}
