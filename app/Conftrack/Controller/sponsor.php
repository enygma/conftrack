<?php

$app->group('/sponsor', function() use ($app) {

  $app->get('', function($request, $response, $args) {
    $sponsors = new \Conftrack\Collection\Sponsors($this->getContainer()->get('db'));
    $sponsors->findAll();
    
    $data = [
      'sponsors' => $sponsors->toArray(true)
    ];
    $this->view->render($response, 'sponsor/view.twig', $data);
  });

  $app->get('/view/{sponsorId}', function($request, $response, $args) {
    $db = $this->getContainer()->get('db');

    $sponsor = new \Conftrack\Model\Sponsor($db);
    $sponsor->findById($args['sponsorId']);

    $data = [
      'sponsor' => $sponsor->toArray(),
      'users' => $sponsor->users->toArray(true)
    ];
    $this->view->render($response, 'sponsor/view.twig', $data);
  });

  $app->get('/create', function($request, $response, $args) {
    $users = new \Conftrack\Collection\Users($this->getContainer()->get('db'));
    $users->findAll();

    $data = [
      'users' => $users->toArray(true)
    ];
    $this->view->render($response, 'sponsor/create.twig', $data);
  });

  $app->post('/create', function($request, $response, $args) {
    $body = $request->getParsedBody();
    $container = $this->getContainer();

// @todo make the file upload work

    $users = new \Conftrack\Collection\Users($container->get('db'));
    $users->findAll();
    $data = [
      'users' => $users->toArray(true),
      'success' => false
    ];

    $sponsor = new \Conftrack\Model\Sponsor($container->get('db'));
    $sponsor->load([
      'name' => $body['name'],
      'description' => $body['description'],
      'logo' => ''
    ]);

    try {
      $sponsor->verify();
      $sponsor->save();

      if (!empty($body['user-id-list'])) {
        $list = explode(',', $body['user-id-list']);

        foreach ($list as $userId) {
          if (empty($userId)) {
            continue;
          }
          // Add records linking the users to the sponsor
          $sponsorUser = new \Conftrack\Model\SponsorUser($container->get('db'));
          $sponsorUser->load([
            'sponsor_id' => $sponsor->id,
            'user_id' => $userId
          ]);
          $sponsorUser->save();
        }
      }

      $message = 'Sponsor created successfully!';
      $data['success'] = true;
    } catch (\Exception $e) {
      $message = "Error: ".implode("\n", $sponsor->getMessages());
    }
    $type = ($data['success'] == false) ? 'danger' : 'success';
    $this->flash->addMessage($type, $message);

    $this->view->render($response, 'sponsor/create.twig', $data);
  });
});
