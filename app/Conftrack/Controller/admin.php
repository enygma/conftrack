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

  $app->get('/users/status', function($request, $response, $args) {
    $data = [];
    $body = $request->getParsedBody();

    error_log(print_r($body, true));

    return $response->withJson($data);
  });
});
