<?php

/**
 * Created by PhpStorm.
 * User: Niran
 * Date: 4/25/2016
 * Time: 3:35 PM
 */
class MW_CheckAuth
{
	private $rendere;
	private $http_service;

	public function __construct($http_service){
		$this->renderer = new \Slim\Views\PhpRenderer('./templates');
		$this->http_service = $http_service;
	}

	public function __invoke($request, $response, $next){
		$uri = $request->getUri();
		$path = $uri->getPath();
		if (!isset($_SESSION['SYSAUTH']) && $path != '/login') {
			$onLoad = [
				'modules' => ['form-login'],
				'title'   => 'Tremont UI Login'
			];

			return $this->renderer->render($response, '/main.php', $onLoad);
		} else if ($path != '/login') {
			$token = $_SESSION['SYSAUTH'];

			$auth_user_result = $this->http_service->get("authentications/user/$token")->body;

			if ($auth_user_result->api_success == 'false') {

				print_r($auth_user_result->result);
				$onLoad = [
					'modules' => ['form-login'],
					'title'   => 'Tremont UI Login'
				];
				unset($_SESSION['SYSAUTH'], $_SESSION['SYSAUTH_EXPIRES'], $_SESSION['user_details']);

				return $this->renderer->render($response, '/main.php', $onLoad);

			} else {

				$_SESSION['user_details'] = $auth_user_result->result;

			}

		}

		return $next($request, $response);
	}
}