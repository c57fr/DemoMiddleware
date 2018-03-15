<?php
// PSR15 - CSRF
require 'vendor/autoload.php';
use App\Dispatcher;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;


use function Http\Response\send;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


$request = ServerRequest::fromGlobals();
$response = new Response();

$url = (string)$request->getUri()->getPath();



