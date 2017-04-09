<?php 

session_start();

require __DIR__.'/../vendor/autoload.php';

$app = new Slim\App([
	'settings' => [
	    'displayErrorDetails' => true,
	    'addContentLengthHeader' => false,
		'db' => [
			'driver'	=> 'mysql',
			'host'		=> 'localhost',
			'database'	=> 'slim_starter_pack',
			'username'	=> 'root',
			'password'	=> 'siskom10',
			'charset' 	=> 'utf8',
			'collation'	=> 'utf8_unicode_ci',
			'prefix'	=> ''
		]
	]
]);


?>