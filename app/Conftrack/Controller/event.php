<?php

$app->group('/event', function() use ($app) {

  $app->get('/create', function($request, $response, $args) {
    $data = [];
    $this->view->render($response, 'event/create.twig', $data);
  });

});
