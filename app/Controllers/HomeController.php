<?php 

namespace App\Controllers;

class HomeController extends BaseController
{
	public function index($request, $response)
	{
		$message = $this->flash->getMessages();
		return $this->view->render($response, 'home.twig', compact('message'));
	}
}

?>