<?php

$app->group('/user', function() use ($app) {

  $app->get('/login', function($request, $response, $args) {
    $data = [];
    $this->view->render($response, 'user/login.twig', $data);
  });

  $app->post('/login', function($request, $response, $args) {
    $container = $this->getContainer();
		$data = $request->getParsedBody();

    $user = new \Conftrack\Model\User($container->get('db'));
		$user->find(['username' => $data['username']]);

    if ($user->id === null) {
      $this->flash->addMessage('danger', 'Account not found.');
    }

    $subject = new \Conftrack\VerifyUser($user);
    $enforcer = \Psecio\Verify\Enforcer::make('password');

    if ($enforcer->login($subject, $data['password']) === false) {
			$this->flash->addMessage('danger', 'Invalid password!');
			$this->view->render($response, 'user/login.twig', $data);
			return false;
		}

    // Login success! Start up the session
		$this->flash->addMessage('success', 'Login successful!');
		$segment = $container->get('session')->getSegment('default');
		$segment->set('user', $user->toArray(['password']));

		return $response->withRedirect('/user/dashboard');

    $this->view->render($response, 'user/login.twig', $data);
  });

  $app->get('/logout', function($request, $response, $args) {
    // Clear out the session
    $this->getContainer()->get('session')->clear();

    // Redirect to the main page
    return $response->withRedirect('/');
  });

  $app->get('/register', function($request, $response, $args) {
    $data = [];
    $this->view->render($response, 'user/register.twig', $data);
  });

  $app->post('/register', function($request, $response, $args) {
    $data = [];

    $body = $request->getParsedBody();
    $user = new \Conftrack\Model\User($this->getContainer()->get('db'));
    $data = ['success' => false];

		$user->load([
			'password' => $body['password'],
      'username' => $body['username'],
			'name' => $body['full_name'],
			'email' => $body['email'],
      'status' => 'active'
		]);

		try {
			$user->verify();
			$user->save();

			// $this->flash->addMessage('success', 'User created successfully!');
      $message = 'User created successfully!';
      $data['success'] = true;
		} catch (\Exception $e) {
      $message = "Error: ".implode("\n", $user->getMessages());
		}
    $type = ($data['success'] == false) ? 'danger' : 'success';
    $this->flash->addMessage($type, $message);

    $this->view->render($response, 'user/register.twig', $data);
  });

  $app->get('/dashboard', function($request, $response, $args) {
    $data = [];
    $this->view->render($response, 'user/dashboard.twig', $data);
  });

  $app->get('/view/{userId}', function($request, $response, $args) {
    $user = new \Conftrack\Model\User($this->getContainer()->get('db'));
    $user->findById($args['userId']);

    $data = [
      'user' => $user->toArray()
    ];
    $this->view->render($response, 'user/view.twig', $data);
  });
});
