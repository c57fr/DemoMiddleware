<?php namespace GC7;


use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CsrfMiddleware implements MiddlewareInterface {


  /**
   * Process an incoming server request and return a response, optionally delegating
   * response creation to a handler.
   *
   * @param ServerRequestInterface  $request
   * @param RequestHandlerInterface $handler
   *
   * @return ResponseInterface
   */
  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface {

    if (in_array($request->getMethod(), ['PUT', 'POST', 'DELETE'])) {

    }
    return $handler->process($request);
  }

}
