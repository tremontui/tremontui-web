<?php

/**
 * Created by PhpStorm.
 * User: Niran
 * Date: 4/25/2016
 * Time: 3:27 PM
 */
class MW_TrailingSlashes
{
	public function __invoke($request, $response, $next)
	{
		$uri = $request->getUri();
		$path = $uri->getPath();
		if ($path != '/' && substr($path, -1) == '/') {
			// permanently redirect paths with a trailing slash
			// to their non-trailing counterpart
			$uri = $uri->withPath(substr($path, 0, -1));

			return $response->withRedirect((string)$uri, 301);
		}

		return $next($request, $response);
	}
}