<?php // PSR15 - CSRF
require 'vendor/autoload.php';
//
//use App\Dispatcher;
use Middlewares\Whoops;

//use App\PoweredByMiddleware;
//use GuzzleHttp\Psr7\Response;
//use GuzzleHttp\Psr7\ServerRequest;
//use Psr\Http\Message\ResponseInterface;
//use Psr\Http\Message\ServerRequestInterface;

use App\Dispatcher;
use App\PoweredByMiddleware;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;
use Psr\Http\Message\ResponseInterface;

$request = ServerRequest::fromGlobals();
$response = new Response();

$url = (string)$request->getUri()->getPath();

$menuMiddleware = function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($url) {
//  $response->getBody()->write('MENU');
  $response->getBody()->write('
  <a href="/">Home</a> |
  <a href="/blog/">Blog/</a> |
  <a href="/blog">Blog</a> |
  <a href="/contact">Contact</a>
  <hr>');
  $response->getBody()->write('<h1>' . $url . '</h1><hr>');
  $response = $next($request, $response);
  return $next($request, $response);
};

$trailingSlashMiddleware = function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($url) {
  $response = new Response();
  if (strlen($url) - 1 && $url[-1] === '/') {
    $url = ($url === '/') ? $url : substr($url, 0, -1);
    return $response->withHeader('Location', $url)
      ->withStatus(301);
  }
  return $next($request, $response);
};

$quoteMiddleware = function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
  $response->getBody()->write('"');
  $response = $next($request, $response);
  $response->getBody()->write('"');
  return $next($request, $response);
};

$app = function (ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $response, callable $next) use ($url) {
  if ($url === '/')
    $response->getBody()->write('Accueil');
  elseif ($url === '/blog')
    $response->getBody()->write('Je suis sur le blog');
  elseif ($url === '/contact')
    $response->getBody()->write('Me contacter');
  else {
    $response->getBody()->write('Not found');
    $response = $response->withStatus(404);
  }
  return $response;
};

$dispatcher = new Dispatcher();
//$dispatcher->pipe(new Whoops());
$dispatcher->pipe(new PoweredByMiddleware());
//$dispatcher->pipe($menuMiddleware);
$dispatcher->pipe($app);
//
//var_dump($dispatcher);
send($dispatcher->handle($request));


?>

<hr>
<pre>

PSR7:

composer require psr/http-message
composer require guzzlehttp/psr7
composer require http-interop/response-sender

PSR15:

http-interop/http-middleware abandoned

Package http-interop/http-server-middleware is abandoned, you should avoid using it. Use psr/http-server-middleware instead.

      "guzzlehttp/guzzle": "^6.3",
    "middlewares/whoops": "^1.0",
    "psr/http-message": "^1.0",
    "psr/http-server-middleware": "^1.0"


  "require": {
    "php": ">=7.1.0"
  },
  "scripts": {
    "test": "phpunit --coverage-html cov"
  },
    "require-dev": {
    "phpunit/phpunit": "^6.5.0."
  },
  "config": {
    "preferred-install": "dist",
    "optimize-autoloader": true,
    "sort-packages": true
  },
  "minimum-stability": "stable",
  "prefer-stable": true
</pre>
