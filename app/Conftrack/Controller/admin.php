<?php

$app->group('/admin', function() use ($app) {

  /* Default page route */
  $app->get('/users', function($request, $response, $args) {
    $users = new \Conftrack\Collection\Users($this->getContainer()->get('db'));
    $users->findAll();

    $data = [
      'users' => $users->toArray(true)
    ];
    $this->view->render($response, 'admin/users.twig', $data);

  });

  $app->post('/users/status', function($request, $response, $args) {
    $data = ['success' => false];
    $body = $request->getParsedBody();

    $user = new \Conftrack\Model\User($this->getContainer()->get('db'));
    $user->findById($body['userId']);

    if ($user->id == null) {
      throw new \Exception('User not found!');
    } else {
      ($user->status == 'active') ? $user->disable() : $user->enable();
      $data['success'] = true;
    }

    return $response->withJson($data);
  });
});
