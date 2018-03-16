<?php namespace App;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class PoweredByMiddleware
 * @package App
 */
class PoweredByMiddleware implements MiddlewareInterface {

  /**
   * Process an incoming server request and return a response, optionally delegating
   * response creation to a handler.
   */
  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
    $response = $handler->handle($request);
    return $response->withHeader('X-Powered-By', 'GC7');
  }

}
