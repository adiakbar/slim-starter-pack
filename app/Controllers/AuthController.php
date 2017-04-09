<?php 

namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator as v;

class AuthController extends BaseController
{
	public function getRegister($request, $response)
	{
		$message = $this->flash->getMessages();
		return $this->view->render($response, 'auth/register.twig', compact('message'));
	}

	public function postRegister($request, $response)
	{
		$validation = $this->validator->validate($request, [
			'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
			'username' => v::noWhitespace()->notEmpty()->alpha(),
			'password' => v::noWhitespace()->notEmpty(),
		]);

		if($validation->failed()) {
			$this->flash->addMessage('warning', 'Cek kembali data yang di masukkan');
			return $response->withRedirect($this->router->pathFor('register'));
		}

		User::create([
			'email' => $request->getParam('email'),
			'username' => $request->getParam('username'),
			'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
		]);

		$auth = $this->auth->attempt(
			$request->getParam('username'), 
			$request->getParam('password')
		);

		$this->flash->addMessage('success', 'Berhasil mendaftar');
		return $response->withRedirect($this->router->pathFor('home'));
	}

	public function getLogin($request, $response)
	{
		$message = $this->flash->getMessages();
		return $this->view->render($response, 'auth/login.twig', compact('message'));
	}

	public function postLogin($request, $response)
	{
		$validation = $this->validator->validate($request, [
			'username' => v::noWhitespace()->notEmpty()->alpha(),
			'password' => v::noWhitespace()->notEmpty(),
		]);

		if($validation->failed()) {
			return $response->withRedirect($this->router->pathFor('login'));
		}

		$auth = $this->auth->attempt(
			$request->getParam('username'), 
			$request->getParam('password')
		);
		if(!$auth)  {
			$this->flash->addMessage('warning', 'Cek Lagi Username dan Password Kamu');
			return $response->withRedirect($this->router->pathFor('login'));
		}

		$this->flash->addMessage('success', 'Berhasil login');
		return $response->withRedirect($this->router->pathFor('home'));
	}

	public function logout($request, $response)
	{
		$this->auth->logout();
		return $response->withRedirect($this->router->pathFor('home'));
	}
}

?>