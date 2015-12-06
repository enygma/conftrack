<?php
require_once 'vendor/autoload.php';

session_start();

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

define('APP_PATH', __DIR__.'/app');
define('APP_NAMESPACE', $_ENV['APP_NAMESPACE']);

// Custom autoloader
spl_autoload_register(function($class) {
    $path = APP_PATH.'/'.str_replace('\\', '/', $class).'.php';
    if (is_file($path)) {
        require_once $path;
    }
});

$container = new \Slim\Container;

//----------------------
$container['view'] = function ($c) {
    $view = new \Conftrack\View\TemplateView('../templates', [
        'cache' => false
    ]);
    $view['container'] = $c;
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));
    return $view;
};

$container['user'] = function()
{
	$sessionFactory = new \Aura\Session\SessionFactory;
	$session = $sessionFactory->newInstance([]);

	$user = $session->getSegment('default')->get('user');
	return $user;
};

$container['db'] = function ($c) {
	$dsn = 'mysql:dbname='.$_ENV['DB_NAME'].';host='.$_ENV['DB_HOST'];
	return new \PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
};

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

// Make the session instance
$container['session'] = function()
{
    $data = array();
    $sessionFactory = new \Aura\Session\SessionFactory;
    return $sessionFactory->newInstance($data);
};

$container['errorHandler'] = function($c) {
    return function ($request, $response, $ex) use ($c) {
        echo $c['view']->render($response, 'error/index.twig', ['message' => $ex->getMessage()]);
        return $c['response'];
    };
};

//----------------------

$app = new \Slim\App($container);
$app->add(new \Conftrack\Middleware\Auth());

// Load the controllers
$dir = new DirectoryIterator(APP_PATH.'/'.APP_NAMESPACE.'/Controller');
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        require_once $fileinfo->getPathname();
    }
}

$app->run();
