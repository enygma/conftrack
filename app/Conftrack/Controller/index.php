<?php

/* Index routes */
$app->group('/', function() use ($app) {

  /* Default page route */
  $app->get('/', function($request, $response, $args) {
    $data = [];
    $this->view->render($response, 'index/index.twig', $data);

  });
});
