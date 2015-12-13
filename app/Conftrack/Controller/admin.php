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

  $app->get('/groups', function($request, $response, $args) {
    $groups = new \Conftrack\Collection\Groups($this->getContainer()->get('db'));
    $groups->findAll();

    $data = [
      'groups' => $groups->toArray(true)
    ];

    $this->view->render($response, 'groups/index.twig', $data);
  });

  $app->get('/groups/create', function($request, $response, $args) {
    $data = [];
    $this->view->render($response, 'groups/create.twig', $data);
  });

  $app->post('/groups/create', function($request, $response, $args) {
    $data = ['success' => false];
    $body = $request->getParsedBody();

    $group = new \Conftrack\Model\Group($this->getContainer()->get('db'));
    $group->load([
      'name' => $body['name'],
      'group_key' => $body['key'],
      'description' => $body['description']
    ]);

    try {
      $group->verify();
      $group->save();

      $message = 'Group created successfully!';
      $data['success'] = true;
    } catch (\Exception $e) {
      $message = "Error: ".implode("\n", $group->getMessages());
    }
    $type = ($data['success'] == false) ? 'danger' : 'success';
    $this->flash->addMessage($type, $message);

    $this->view->render($response, 'groups/create.twig', $data);
  });
});
