<?php 

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->get('/', 'HomeController:index')->setName('home');

$app->group('', function() {
	$this->get('/register', 'AuthController:getRegister')->setName('register');
	$this->post('/register', 'AuthController:postRegister');

	$this->get('/login', 'AuthController:getLogin')->setName('login');
	$this->post('/login', 'AuthController:postLogin');
})->add(new GuestMiddleware($container));

$app->get('/logout', 'AuthController:logout')->setName('logout')
	->add(new AuthMiddleware($container));

?>