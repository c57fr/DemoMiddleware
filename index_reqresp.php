<?php
require 'vendor/autoload.php';

use App\Dispatcher;
use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\Response;
use function Http\Response\send;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


$trailingSlash = function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
  $url = (string)$request->getUri();

  if (!empty($url) && $url[-1] === '/') {
    $response = new Response();
    return $response->withHeader('Location', substr($url, 0, -1))
      ->withStatus(301);
  }
  return $next($request, $response);
};


$quoteMiddleware = function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
  $response->getBody()->write('"');
  $response = $next($request, $response);
  $response->getBody()->write('"');
  return $response;
};

$app = function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
  $url = $request->getUri()->getPath();
  if ($url === '/blog') {
    $response->getBody()->write('Je suis sur le Blog');

  } elseif ($url === '/contact') {
    $response->getBody()->write('Me contacter');

  } else {
    $response->getBody()->write('Not Found');
    $response = $response->withStatus(404);
  }
  return $response;
};


$request = ServerRequest::fromGlobals();

$response = new Response();

$dispatcher = new Dispatcher();
$dispatcher->pipe($trailingSlash);
//$dispatcher->pipe(new \App\PoweredByMiddleware());
$dispatcher->pipe(new \Psr7Middlewares\Middleware\FormatNegotiator());
$dispatcher->pipe($quoteMiddleware);
$dispatcher->pipe($app);

send($dispatcher->handle($request, $response));



// todoli cf; https://github.com/middlewares/geolocation
