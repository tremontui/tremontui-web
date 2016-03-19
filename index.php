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

    return $next($request, $response);
});
// Check if an SYSAUTH is saved to the session or the user is currently attempting to log in
$app->add( function( Request $request, Response $response, callable $next ) {
	$uri = $request->getUri();
	$path = $uri->getPath();
    if( !isset( $_SESSION['SYSAUTH']) && $path != '/login' ){
		$onload = ['modules' => ['form-login'], 'title' =>'Tremont UI Login'];
		return $this->renderer->render( $response, '/main.php', $onload );
	}
	
	return $next( $request, $response );
});

$app->get( '/', function( $request, $response, $args ){
	
	$onload = ['title' => 'Tremont UI'];
	
	return $this->renderer->render( $response, '/main.php', $onload );
	
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