<?php namespace App;



use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CsrfMiddleware{

  public function process(ServerRequestInterface $request, DelegateInterface $delegate):ResponseInterface {

  }
}
