<?php namespace App;



use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CsrfMiddleware implements  MiddlewareInterface{

  public function process(ServerRequestInterface $request, DelegateInterface $delegate):ResponseInterface {

  }
}
