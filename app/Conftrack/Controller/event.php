<?php

$app->group('/event', function() use ($app) {

  $app->get('/create', function($request, $response, $args) {
    $sponsors = new \Conftrack\Collection\Sponsors($this->getContainer()->get('db'));
    $sponsors->findAll();

    $data = [
      'sponsors' => $sponsors->toArray(true)
    ];
    $this->view->render($response, 'event/create.twig', $data);
  });

});
