<?php
// PSR15 - CSRF
require 'vendor/autoload.php';
use App\Dispatcher;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

//use Gc7\Functions;
//echo 'Page title: ' . Functions::pageTitle() . '<hr>';


$request = ServerRequest::fromGlobals();
$response = new Response();

$url = (string)$request->getUri()->getPath();


$trailingSlashMiddleware = function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($url) {
  $response = new Response();
  if (strlen($url)-1 && $url[-1] === '/') {
    $url= ($url==='/')?$url:substr($url, 0, -1);
    return $response->withHeader('Location', $url)
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
  return $response;
};


$app = function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($url) {

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
  $response= $response->withHeader('X-Powered-By', 'Gc7');
  return $response;
};

$dispatcher = new Dispatcher();
$dispatcher->pipe($trailingSlashMiddleware);
$dispatcher->pipe($menuMiddleware);
$dispatcher->pipe($quoteMiddleware);
$dispatcher->pipe($app);

send($dispatcher->process($request, $response));

/*
$response = $trailingSlashMiddleware($request, $response, function ($request, $response) use ($quoteMiddleware, $app) {
  return $quoteMiddleware($request, $response, function ($request, $response) use ($app) {
    return $app($request, $response, function ($request, $response) {
      return $response;
    });
  });
});
send($response);
*/

