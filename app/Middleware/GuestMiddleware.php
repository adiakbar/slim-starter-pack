<?php

namespace App\Middleware;

class GuestMiddleware extends BaseMiddleware
{
	public function __invoke($request, $response, $next)
	{
		// kalau sudah login balekan ke home
		if($this->container->auth->check()) {
			return $response->withRedirect($this->container->router->pathFor('home'));
		}
		return $next($request, $response);
	}
}

?>