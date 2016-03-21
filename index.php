<?php
/**
 * BOOTSTRAP
 */
require_once './vendor/autoload.php';
require_once './bootstrap.php';

session_start();

/**
 *	NAMESPACING
 */
use Slim\Views\PhpRenderer;	
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$configuration = [
	'settings' => [
		'displayErrorDetails' => true,
	],
];
$c = new \Slim\Container( $configuration );

$app = new Slim\App( $c );

$container = $app->getContainer();
$container['renderer'] = new PhpRenderer( './templates' );
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

/**
 *	MIDDLEWARE
 */
$app->add( function( Request $request, Response $response, callable $next ) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath(substr($path, 0, -1));
        return $response->withRedirect((string)$uri, 301);
    }

    return $next( $request, $response );
});
// Check if an SYSAUTH is saved to the session or the user is currently attempting to log in
$app->add( function( Request $request, Response $response, callable $next ) use( $api_ini ){
	$uri = $request->getUri();
	$path = $uri->getPath();
    if( !isset( $_SESSION['SYSAUTH']) && $path != '/login' ){
		$onload = [
			'modules'=>['form-login'],
			'title'=>'Tremont UI Login'
		];
		return $this->renderer->render( $response, '/main.php', $onload );
	} else if( $path != '/login' ) {
		$token = $_SESSION['SYSAUTH'];
		
		$auth_user_result = \Httpful\Request::get( $api_ini['url'] . "authentications/user/$token" )
			->addHeaders(['SYSAUTH'=>$token])
			->expectsJson()
			->send()->body;

		if( $auth_user_result->api_success == 'false' ){
			
			print_r( $auth_user_result->result );
			$onload = [
				'modules'=>['form-login'],
				'title'=>'Tremont UI Login'
			];
			unset( $_SESSION['SYSAUTH'], $_SESSION['SYSAUTH_EXPIRES'] );
			return $this->renderer->render( $response, '/main.php', $onload );
			
		} else {

			$_SESSION['user_details'] = $auth_user_result->result;
			
		}
		
	}
	
	return $next( $request, $response );
});

$app->group( '/api', function() use( $api_ini ){
	
	$this->get( '/users', function( $request, $response, $args ) use( $api_ini ){
		$token = $_SESSION['SYSAUTH'];
		
		$api_response = \Httpful\Request::get( $api_ini['url'] . "users")
			->addHeaders(['SYSAUTH'=>$token])
			//->expectsJson()
			->send();
		$api_response_body = $api_response->body;
		return json_encode( $api_response_body->result->result );
	});
	
});

$app->get( '/', function( $request, $response, $args ){
	
	$onload = [
		'modules'=>['dashboard'],
		'title' => 'Tremont UI'
	];
	
	return $this->renderer->render( $response, '/main.php', $onload );
	
});

$app->get( '/users', function( $request, $response, $args ) use( $api_ini ){
	$token = $_SESSION['SYSAUTH'];
	$onload = [
		'modules'=>['table-users'],
		'api_config'=>json_encode( $api_ini ),
		'title'=>'Tremont UI Users'
	];
	
	return $this->renderer->render( $response, '/main.php', $onload );
});

$app->get( '/account', function( $request, $response, $args ) use( $api_ini ){
	$token = $_SESSION['SYSAUTH'];
	
	$onload = [
		'modules'=>[],
		'title'=>'Tremont UI - Channel Advisor Authentication'
	];
	
	$api_response = \Httpful\Request::get( $api_ini['url'] . "channeladvisor/refresh_token/$token")
		->addHeaders(['SYSAUTH'=>$token])
		//->expectsJson()
		->send();
	$api_response_body = $api_response->body;
	
	if( $api_response_body->api_success == 'false' ){
		$onload['modules'][] = 'ca-auth-series';
	} else {
		$onload['modules'][] = 'ca-auth-afirm';
	}
	
	//print_r( $api_response_body );
	
	return $this->renderer->render( $response, '/main.php', $onload );
	
});

$app->get( '/ca_authorize', function( $request, $response, $args ) use( $api_ini ){
	$token = $_SESSION['SYSAUTH'];
	
	$api_response = \Httpful\Request::get( $api_ini['url'] . "channeladvisor/authorize" )
		->addHeaders(['SYSAUTH'=>$token])
		//->expectsJson()
		->send();
	$api_response_body = $api_response->body;
	print_r( $api_response_body );
	
});

$app->post( '/add_refresh', function( $request, $response, $args ) use( $api_ini ){
	$token = $_SESSION['SYSAUTH'];
	$params = $request->getParsedBody();
	$refresh_token = $params['refresh'];

	$api_response = \Httpful\Request::post( $api_ini['url'] . "channeladvisor/refresh_token?token=$refresh_token" )
		->addHeaders(['SYSAUTH'=>$token])
		//->expectsJson()
		->send();
	$api_response_body = $api_response->body;
	print_r( $api_response_body );
	if( $api_response_body->api_success == 'true' ){
		return $response->withStatus(200)->withHeader('Location', './account');
	} else {
		print_r( $api_response_body );
	}

});

$app->post( '/login', function( $request, $response, $args ) use( $api_ini ){
	
	$params = $request->getParsedBody();
	$username = $params['username'];
	$password = $params['password'];	
	
	$api_response = \Httpful\Request::post( $api_ini['url'] . "users/verify_username?username=$username" )
		->expectsJson()
		->send();
	$api_response_body = $api_response->body;
	
	if( $api_response_body->api_success == 'true' ){
		
		$user_id = $api_response_body->result->User_ID;
		
		$api_verify_pass = \Httpful\Request::post( $api_ini['url'] . "users/verify_password?user_id=$user_id&password=$password" )
			->expectsJson()
			->send();
		$api_verify_pass_body = $api_verify_pass->body;

		if( $api_verify_pass_body->api_success == 'true' ){
			
			$verification = $api_verify_pass_body->result;
			if( $verification->password_verified == 'true' ){
				
				$authentication = $verification->authentication;
				$token = $authentication->token;
				$expires =$authentication->expires;
			
				$_SESSION['SYSAUTH'] = $token;
				$_SESSION['SYSAUTH_EXPIRES'] = $expires;
				
				return $response->withStatus(200)->withHeader('Location', './');
				
			}
			
		}
		
	}
	
});

$app->run();
?>