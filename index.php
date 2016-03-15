<?php
require_once './vendor/autoload.php';
require_once './bootstrap.php';

session_start();

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

$app->add( function( Request $request, Response $response, callable $next ) {

	$path = $request->getUri()->getPath();
	
    if( !isset( $_SESSION['access_token']) && $path != '/login' ){
		
		$load = ['modules' => ['form-login'], 'title' =>'Tremont UI Login'];
		
		return $this->renderer->render( $response, '/main.php', $load );
	}
	
	return $next( $request, $response );
    
});

$app->get( '/', function( $request, $response, $args ){
	
	$load = ['title' => 'Tremont UI'];
	
	return $this->renderer->render( $response, '/main.php', $load );
	
});

$app->post( '/login', function( $request, $response, $args ) use( $api_ini ){
	
	$api_response = \Httpful\Request::get( $api_ini['url'] )
		->send();
	
	print_r( $api_response->body );
	
});

$app->run();
?>