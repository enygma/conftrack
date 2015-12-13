<?php

/* Index routes */
$app->group('/', function() use ($app) {

  /* Default page route */
  $app->get('/', function($request, $response, $args) {
    $data = [];
    $this->view->render($response, 'index/index.twig', $data);

  });
});

$app->get('/error', function($request, $response, $args) {
  $messageList = [];
  $currentMessages = $this->flash->getMessages();

  if (empty($currentMessages)) {
    $currentMessages['danger'] = ['There was an error on your request'];
  }
  foreach ($currentMessages as $level => $messages) {
    foreach ($messages as $message) {
      $messageList[] = $message;
    }
  }
  $data = [
    'message' => implode("\n", $messageList)
  ];
	$this->view->render($response, 'error/index.twig', $data);
});
