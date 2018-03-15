<?php
// PSR15 - CSRF
require 'vendor/autoload.php';
//use App\Dispatcher;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;


use function Http\Response\send;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


$request = ServerRequest::fromGlobals();
$response = new Response();

$url = (string)$request->getUri()->getPath();

$response->getBody()->write('Oki');

$response->getBody()->write('
  <a href="/">Home</a> |
  <a href="/blog/">Blog/</a> |
  <a href="/blog">Blog</a> |
  <a href="/contact">Contact</a>
  <hr>');
$response->getBody()->write('<h1>' . $url . '</h1><hr>');


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


send($response);



