<?php 

namespace App\Middleware;

class OldInputMiddleware extends BaseMiddleware
{
	public function __invoke($request, $response, $next)
	{
		if(!isset($_SESSION['old'])) { $_SESSION['old'] = array(); } 
		$this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
		$_SESSION['old'] = $request->getParams();

		return $next($request, $response);
	}
}

?>