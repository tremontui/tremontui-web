<?php
/**
 * BOOTSTRAP
 */
require_once './vendor/autoload.php';
require_once './bootstrap.php';

session_start();

/**
 *    ALIASING
 */
use Slim\Views\PhpRenderer;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$configuration = [
	'settings' => [
		'displayErrorDetails' => TRUE,
	],
];
$c = new \Slim\Container($configuration);
$app = new Slim\App($c);

$container = $app->getContainer();
$container['renderer'] = new PhpRenderer('./templates');
$container['flash'] = function () {
	return new \Slim\Flash\Messages();
};

$http_api = new Http_Service($api_ini['url']);
if (isset($_SESSION['SYSAUTH'])) {
	$http_api->add_header('SYSAUTH', $_SESSION['SYSAUTH']);
}

/**
 *    MIDDLEWARE
 */
$app->add(new MW_TrailingSlashes());
// Check if an SYSAUTH is saved to the session or the user is currently attempting to log in
$app->add(new MW_CheckAuth($http_api));

//API ROUTES
$app->group('/api', function () use ($http_api) {

	$this->get('/users', function ($request, $response, $args) use ($http_api) {

		$api_response = $http_api->get("users")->body;

		return $response->withJson($api_response->result->result);

	});

	$this->post('/users', function ($request, $response, $args) use ($http_api) {

		$params = json_decode($request->getParsedBody()['userData'], TRUE);
		$username = $params['username'];
		$password = $params['password'];
		$f_name = $params['f_name'];
		$l_name = $params['l_name'];
		$email = $params['email'];

		$api_response = $http_api->post("users?username=$username&first_name=$f_name&last_name=$l_name&email=$email&password=$password")
			->body;

		return json_encode($api_response);

	});

	$this->get('/brands_canonical', function ($request, $response, $args) use ($http_api) {

		$params = $request->getQueryParams();
		$brand_name = check_replacers($params['brand_name']);

		$api_resource = "brands_canonical/by_name/$brand_name";

		$api_result = $http_api->get($api_resource);

		return $response->withJson($api_result->body);

		//return $response->withJson( $params['brand_name'], 200 );

	});

	$this->get('/brand_items', function ($request, $response, $args) use ($http_api) {

		$params = $request->getQueryParams();
		$brand_name = check_replacers($params['brand_name']);

		$api_resource = "items_canonical/by_brandname/$brand_name";

		$api_result = $http_api->get($api_resource);

		return $response->withJson($api_result->body);

		//return $response->withJson( $params['brand_name'], 200 );

	});

	$this->post('/inventory_tasks', function ($request, $response, $args) use ($http_api) {
		$user_id = $_SESSION['user_details']->User_ID;
		$params = json_decode($request->getParsedBody()['data'], TRUE);

		$task_type = $params['task_type'];

		$api_resource = "inventory_tasks";

		$api_response = $http_api->post($api_resource . "?task_type=$task_type&user_id=$user_id")
			->body;

		return $response->withJson($api_response);

	});

});

$app->get('/', function ($request, $response, $args) {

	$onload = [
		'modules' => ['dashboard'],
		'title'   => 'Tremont UI'
	];

	return $this->renderer->render($response, '/main.php', $onload);

});

$app->get('/logoff', function ($request, $response, $args) {

	$_SESSION = [];

	return $response->withStatus(200)->withHeader('Location', './');

});

$app->group('/documentation', function () {

	$this->get('', function ($request, $response, $args) {
		$params = $request->getQueryParams();
		$topic = '';
		if (isset($params['topic'])) {
			$topic = $params['topic'];
		}

		$token = $_SESSION['SYSAUTH'];
		$onload = [
			'modules' => ['documentation'],
			'topic'   => $topic,
			'title'   => 'Tremont UI - Documentation'
		];

		return $this->renderer->render($response, '/main.php', $onload);
	});

});

$app->get('/users', function ($request, $response, $args) use ($api_ini) {
	$token = $_SESSION['SYSAUTH'];
	$onload = [
		'modules'    => ['table-users'],
		'api_config' => json_encode($api_ini),
		'title'      => 'Tremont UI Users'
	];

	return $this->renderer->render($response, '/main.php', $onload);
});

$app->get('/account', function ($request, $response, $args) use ($http_api) {
	$token = $_SESSION['SYSAUTH'];

	$onload = [
		'modules' => [],
		'title'   => 'Tremont UI - Channel Advisor Authentication'
	];
	$api_response = $http_api->get("channeladvisor/refresh_token/$token")->body;

	if ($api_response->api_success == 'false') {
		$onload['modules'][] = 'ca-auth-series';
	} else {
		$onload['modules'][] = 'ca-auth-afirm';
	}

	return $this->renderer->render($response, '/main.php', $onload);

});

/*$app->group( '/update_inventory', function() use( $api_ini, $http_api ){
	
	$this->get( '', function( $request, $response, $args ) use( $api_ini, $http_api ){
		$token = $_SESSION['SYSAUTH'];
	
		$onload = [
			'modules'=>['update_inventory'],
			'api_config'=>json_encode( $api_ini ),
			'title'=>'Tremont UI - Update Inventory'
		];
		
		return $this->renderer->render( $response, '/main.php', $onload );
		
	});
	
});*/

$app->group('/channel_advisor', function () use ($api_ini, $http_api) {

	$this->get('/base_items', function ($request, $response, $args) use ($api_ini, $http_api) {

		$api_resource = "channeladvisor/baseitems";

		$api_result = $http_api->get($api_resource);

		return $response->withJson($api_result->body);

	});

});

$app->get('/items/count', function ($request, $response, $args) use ($api_ini, $http_api) {

	//$params = $request->getParsedBody()['items'];

	$api_resource = "items/count";

	$api_result = $http_api
		->get($api_resource);

	return $response->withJson($api_result->body/*$api_result->body*/);

});

$app->get('/items/update_round', function ($request, $response, $args) use ($api_ini, $http_api) {

	//$params = $request->getParsedBody()['items'];

	$api_resource = "channeladvisor/updateitemsfull";

	$api_result = $http_api
		->get($api_resource);

	return $response->withJson($api_result->body/*$api_result->body*/);

});

$app->post('/initialize_items', function ($request, $response, $args) use ($api_ini, $http_api) {

	$params = $request->getParsedBody()['items'];

	$api_resource = "items/initialize_bundle";

	$api_result = $http_api
		->withBody($params)
		->post($api_resource);

	return $response->withJson($api_result->body/*$api_result->body*/);

});

$app->group('/inventory_interface', function () use ($api_ini, $http_api) {

	$this->get('', function ($request, $response, $args) use ($api_ini, $http_api) {

		$onload = [
			'api_config' => json_encode($api_ini),
			'title'      => 'Tremont UI - Inventory Interface'
		];

		return $this->renderer->render($response, '/inventory_interface.php', $onload);

	});
});

$app->group('/brand_manage', function () use ($api_ini, $http_api) {

	$this->get('', function ($request, $response, $args) use ($api_ini, $http_api) {

		$quick_brands = $http_api->get('quick_brands/user/' . $_SESSION['user_details']->User_ID)->body->result->result;

		$onload = [
			'modules'      => [
				'research-brand',
				'quick-brands'
			],
			'api_config'   => json_encode($api_ini),
			'quick_brands' => json_encode($quick_brands),
			'title'        => 'Tremont UI - Brand Management'
		];

		return $this->renderer->render($response, '/main.php', $onload);

	});

	$this->get('/brand', function ($request, $response, $args) use ($api_ini, $http_api) {
		$token = $_SESSION['SYSAUTH'];

		$params = $request->getQueryParams();
		$brand_name = check_replacers($params['brand_name']);

		$onload = [
			'api_config' => json_encode($api_ini),
			'brand_name' => $brand_name,
			'title'      => "Tremont UI - Brand Management - $brand_name"
		];

		return $this->renderer->render($response, '/brand_overview.php', $onload);

	});

	$this->group('/quick_brand', function () use ($http_api) {

		$this->post('', function ($request, $response, $args) use ($http_api) {
			$user_id = $_SESSION['user_details']->User_ID;
			$params = $request->getParsedBody();

			$brand_name = check_replacers($params['brand_name']);

			$uri = "quick_brands?user_id=$user_id&brand_name=$brand_name";
			$http_api->post($uri);

			return $response->withStatus(200)->withHeader('Location', '/brand_manage');
			//print_r( $brand_name );

		});

		$this->get('/delete', function ($request, $response, $args) use ($http_api) {
			$user_id = $_SESSION['user_details']->User_ID;
			$params = $request->getQueryParams();

			$brand_name = check_replacers($params['brand_name']);

			$uri = "quick_brands/delete/$brand_name?user_id=$user_id";
			$api_result = $http_api->post($uri)->body;

			return $response->withJson($api_result, 200);
		});

	});

});

$app->get('/ca_authorize', function ($request, $response, $args) use ($api_ini) {
	$token = $_SESSION['SYSAUTH'];

	$api_response = \Httpful\Request::get($api_ini['url'] . "channeladvisor/authorize")
		->addHeaders(['SYSAUTH' => $token])
		//->expectsJson()
		->send();
	$api_response_body = $api_response->body;
	print_r($api_response_body);

});

$app->post('/add_refresh', function ($request, $response, $args) use ($api_ini) {
	$token = $_SESSION['SYSAUTH'];
	$params = $request->getParsedBody();
	$refresh_token = $params['refresh'];

	$api_response = \Httpful\Request::post($api_ini['url'] . "channeladvisor/refresh_token?token=$refresh_token")
		->addHeaders(['SYSAUTH' => $token])
		//->expectsJson()
		->send();
	$api_response_body = $api_response->body;
	print_r($api_response_body);
	if ($api_response_body->api_success == 'true') {
		return $response->withStatus(200)->withHeader('Location', './account');
	} else {
		print_r($api_response_body);
	}

});

$app->post('/login', function ($request, $response, $args) use ($api_ini) {

	$params = $request->getParsedBody();
	$username = $params['username'];
	$password = $params['password'];

	$api_response = \Httpful\Request::post($api_ini['url'] . "users/verify_username?username=$username")
		->expectsJson()
		->send();
	$api_response_body = $api_response->body;

	if ($api_response_body->api_success == 'true') {

		$user_id = $api_response_body->result->User_ID;

		$api_verify_pass = \Httpful\Request::post($api_ini['url'] . "users/verify_password?user_id=$user_id&password=$password")
			->expectsJson()
			->send();
		$api_verify_pass_body = $api_verify_pass->body;

		if ($api_verify_pass_body->api_success == 'true') {

			$verification = $api_verify_pass_body->result;
			if ($verification->password_verified == 'true') {

				$authentication = $verification->authentication;
				$token = $authentication->token;
				$expires = $authentication->expires;

				$_SESSION['SYSAUTH'] = $token;
				$_SESSION['SYSAUTH_EXPIRES'] = $expires;

				return $response->withStatus(200)->withHeader('Location', './');

			}

		} else {

			return $response->withStatus(401)->withHeader('Location', './');

		}

	}

});

function check_replacers($string)
{
	$replacers = [" " => "zqzszqz", "&" => "zqzazqz"];
	$new_string = $string;
	foreach ($replacers as $find => $replace) {
		$new_string = str_replace($find, $replace, $new_string);
	}

	return $new_string;
}

function revert_replacers($string)
{
	$replacers = ["zqzszqz" => " ", "zqzazqz" => "&"];
	$new_string = $string;
	foreach ($replacers as $find => $replace) {
		$new_string = str_replace($find, $replace, $new_string);
	}

	return $new_string;
}

$app->run();
?>