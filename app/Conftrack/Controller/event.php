<?php

$app->group('/event', function() use ($app) {

  $app->get('', function($request, $response, $args) {
    $events = new \Conftrack\Collection\Events($this->getContainer()->get('db'));
    $events->findAll();

    $data = ['events' => $events->toArray(true)];
    $this->view->render($response, 'event/index.twig', $data);
  });

  $app->get('/create', function($request, $response, $args) {
    $sponsors = new \Conftrack\Collection\Sponsors($this->getContainer()->get('db'));
    $sponsors->findAll();

    $data = [
      'sponsors' => $sponsors->toArray(true)
    ];
    $this->view->render($response, 'event/create.twig', $data);
  });

  $app->get('/view/{eventId}', function($request, $response, $args) {
    $event = new \Conftrack\Model\Event($this->getContainer()->get('db'));
    $event->findById($args['eventId']);

    $sponsors = new \Conftrack\Collection\Sponsors($this->getContainer()->get('db'));
    $sponsors->findAll();

    $data = [
      'event' => $event->toArray(),
      'sponsors' => $sponsors->toArray(true),
      'eventSponsors' => $event->sponsors->toArray(true)
    ];
    $this->view->render($response, 'event/view.twig', $data);
  });

  $app->post('/{eventId}/sponsor', function($request, $response, $args) {
    // Add a sponsor to the event
    $data = ['success' => false];
    $body = $request->getParsedBody();

    $sponsorEvent = new \Conftrack\Model\SponsorEvent($this->getContainer()->get('db'));
    $sponsorEvent->load([
      'event_id' => $args['eventId'],
      'sponsor_id' => $body['sponsorId']
    ]);

    try {
        $sponsorEvent->verify();
        $sponsorEvent->save();
        $data['success'] = true;
        $data['message'] = 'Sponsor added successfully';

    } catch (\Exception $e) {
      $data['message'] = "Error: ".implode("\n", $sponsorEvent->getMessages());
    }

    return $response->withJson($data);
  });

  $app->delete('/{eventId}/sponsor', function($request, $response, $args) {
    $data = ['success' => false];
    $body = $request->getParsedBody();

    $sponsorEvent = new \Conftrack\Model\SponsorEvent($this->getContainer()->get('db'));
    $sponsorEvent->find([
      'sponsor_id' => $body['sponsorId'],
      'event_id' => $args['eventId']
    ]);
    try {
        $data['success'] = $sponsorEvent->delete();
        $data['message'] = 'Sponsor removed successfully';
    } catch (\Exception $e) {
      $data['message'] = "Error: ".implode("\n", $sponsorEvent->getMessages());
    }

    return $response->withJson($data);
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
