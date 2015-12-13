<?php

namespace Conftrack\Middleware;
use Psecio\Invoke\Enforcer;

class Auth
{
  private $container;

  public function __construct(\Slim\Container $container)
  {
    $this->container = $container;
  }

	public function __invoke($request, $response, $next)
  {
    $db = $this->container->get('db');
  	$session = $this->getSession();

  	$currentUser = $session->getSegment('default')->get('user');
    $user = new \Conftrack\Model\User($db);
    $user->findById($currentUser['id']);

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
