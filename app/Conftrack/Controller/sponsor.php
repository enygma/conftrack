<?php

$app->group('/sponsor', function() use ($app) {

  $app->get('', function($request, $response, $args) {
    $sponsors = new \Conftrack\Collection\Sponsors($this->getContainer()->get('db'));
    $sponsors->findAll();

    $data = [
      'sponsors' => $sponsors->toArray(true)
    ];
    $this->view->render($response, 'sponsor/index.twig', $data);
  });

  $app->get('/view/{sponsorId}', function($request, $response, $args) {
    $db = $this->getContainer()->get('db');

    $sponsor = new \Conftrack\Model\Sponsor($db);
    $sponsor->findById($args['sponsorId']);

    $users = new \Conftrack\Collection\Users($db);
    $users->findAll();

    $data = [
      'sponsor' => $sponsor->toArray(),
      'sponsorUsers' => $sponsor->users->toArray(true),
      'users' => $users->toArray(true),
      'files' => $sponsor->files->toArray(true)
    ];
    $this->view->render($response, 'sponsor/view.twig', $data);
  });

  $app->get('/{sponsorId}/file/{hash}', function($request, $response, $args) {

    $file = new \Conftrack\Model\File($this->getContainer()->get('db'));
    $file->find(['hash' => $args['hash']]);

    if ($file->sponsor->id !== $args['sponsorId']) {
      throw new \Exception('Invalid file!');
    }
    echo file_get_contents(APP_PATH.'/upload/sponsor/'.$file->sponsor->id.'/'.$file->hash);
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

      // Handle the file upload
      if (isset($_FILES['logo'])) {
        $sponsor->handleUpload($_FILES['logo']);
      }

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

  $app->get('/edit/{sponsorId}', function($request, $response, $args) {
    $sponsor = new \Conftrack\Model\Sponsor($this->getContainer()->get('db'));
    $sponsor->findById($args['sponsorId']);

    $users = new \Conftrack\Collection\Users($this->getContainer()->get('db'));
    $users->findAll();

    $data = [
      'sponsor' => $sponsor->toArray(),
      'sponsorUsers' => $sponsor->users->toArray(true),
      'action' => 'edit',
      'users' => $users->toArray(true)
    ];
    $this->view->render($response, 'sponsor/create.twig', $data);
  });

  $app->get('/image/{sponsorId}', function($request, $response, $args) {
  });

  $app->post('/edit/{sponsorId}', function($request, $response, $args) {
    $body = $request->getParsedBody();
    $data = ['success' => false];

    $users = new \Conftrack\Collection\Users($this->getContainer()->get('db'));
    $users->findAll();

    $sponsor = new \Conftrack\Model\Sponsor($this->getContainer()->get('db'));
    $sponsor->findById($args['sponsorId']);

    $loadData = ['description' => $body['description']];
    if (isset($body['name'])) {
      $loadData['name'] = $body['name'];
    }
    $sponsor->load($loadData);

    try {
      $sponsor->verify();
      $sponsor->save();
      $data['success'] = true;
      $data['message'] = 'Sponsor saved successfully';
    } catch (\Exception $e) {
      $data['message'] = 'There was an error saving the sponsor';
    }

    $data = array_merge($data, [
      'sponsor' => $sponsor->toArray(),
      'action' => 'edit',
      'users' => $users->toArray(true),
      'sponsorUsers' => $sponsor->users->toArray(true)
    ]);
    $this->view->render($response, 'sponsor/create.twig', $data);
  });

  $app->post('{sponsorId}/user', function($request, $response, $args) {
    $data = ['success' => false];
    $body = $request->getParsedBody();

    $sponsorUser = new \Conftrack\Model\SponsorUser($this->getContainer()->get('db'));
    $sponsorUser->load([
      'user_id' => $body['userId'],
      'sponsor_id' => $args['sponsorId']
    ]);

    try {
      $sponsorUser->verify();
      $sponsorUser->save();
      $data['success'] = true;
      $data['message'] = 'User added successfully';

    } catch (\Exception $e) {
      $data['message'] = "Error: ".implode("\n", $sponsorUser->getMessages());
    }

    return $response->withJson($data);
  });

  $app->delete('{sponsorId}/user', function($request, $response, $args) {
    $data = ['success' => false];
    $body = $request->getParsedBody();

    $sponsorUser = new \Conftrack\Model\SponsorUser($this->getContainer()->get('db'));
    $sponsorUser->find([
      'sponsor_id' => $args['sponsorId'],
      'user_id' => $body['userId']
    ]);

    try {
      $sponsorUser->delete();
      $data['success'] = 'User removed successfully';
    } catch (\Exception $e) {
      $data['message'] = "Error: ".implode("\n", $sponsorUser->getMessages());
    }
    return $response->withJson($data);
  });

});
