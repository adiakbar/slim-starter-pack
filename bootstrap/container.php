<?php 

use Respect\Validation\Validator as v;

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Container untuk database
$container['db'] = function($container) use ($capsule) {
	return $capsule;
};

$container['auth'] = function($container) {
	return new \App\Auth\Auth;
};

$container['flash'] = function($container) {
	return new \Slim\Flash\Messages;
};

// Container untuk view
$container['view'] = function($container) {
	$view = new \Slim\Views\Twig(__DIR__.'/../resources/views', [
		'cache' => false
	]);
	// Instance and add Slim specific extension
	$basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    $view->getEnvironment()->addGlobal('auth', [
    	'check' => $container->auth->check(),
    	'user' => $container->auth->user(),
    ]);

	return $view;
};

$container['validator'] = function($container) {
	return new \App\Validation\Validator;
};

$container['HomeController'] = function($container) {
	return new \App\Controllers\HomeController($container);
};

$container['AuthController'] = function($container) {
	return new \App\Controllers\AuthController($container);
};

// Middleware Global
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));

v::with('App\\Validation\\Rules\\');

?>