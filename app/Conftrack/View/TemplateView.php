<?php

namespace Conftrack\View;

class TemplateView extends \Slim\Views\Twig
{
	public function render($response, $template, $data = [])
	{
		$container = $this['container'];
		$flash = new \Slim\Flash\Messages();
		$messageList = [];

		foreach ($flash->getMessages() as $type => $messages) {
			foreach ($messages as $msg) {
				$messageList[$type][] = $msg;
			}
		}

		$data = array_merge(
			$data,
			['error_messages' => $messageList]
		);

		$session = $this->getSession();
  	$user = $session->getSegment('default')->get('user');
  	if ($user) {
  		$data['user'] = $user;
  	}

		parent::render($response, $template, $data);
  }

	private function getSession()
	{
		$sessionFactory = new \Aura\Session\SessionFactory;
		return $sessionFactory->newInstance([]);
	}
}
