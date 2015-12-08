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

  $app->post('/create', function($request, $response, $args) {
    $body = $request->getParsedBody();
    $message = '';
    $data = ['success' => false];
    $sponsors = new \Conftrack\Collection\Sponsors($this->getContainer()->get('db'));
    $sponsors->findAll();

    $startDate = new \DateTime($body['start_date']);
    $endDate = new \DateTime($body['end_date']);

    $event = new \Conftrack\Model\Event($this->getContainer()->get('db'));
    $event->load([
      'name' => $body['name'],
      'start_date' => $startDate->format('Y-m-d H:i:s'),
      'end_date' => $endDate->format('Y-m-d H:i:s')
    ]);

    try {
      $event->verify();
      $event->save();
      $data['success'] = true;
      $message = 'Event created successfully!';

    } catch (\Exception $e) {
      error_log($e->getMessage());
      $message = "Error: ".implode("\n", $event->getMessages());
    }
    $type = ($data['success'] == false) ? 'danger' : 'success';
    $this->flash->addMessage($type, $message);

    $data = [
      'sponsors' => $sponsors->toArray(true)
    ];

    $this->view->render($response, 'event/create.twig', $data);
  });
});
