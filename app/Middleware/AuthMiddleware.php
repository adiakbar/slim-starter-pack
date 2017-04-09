<?php

namespace App\Middleware;

class AuthMiddleware extends BaseMiddleware
{
	public function __invoke($request, $response, $next)
	{
		// check if the user is not login
		if(!$this->container->auth->check()) {
			return $response->withRedirect($this->container->router->pathFor('login'));
		}
		return $next($request, $response);
	}
}

?>