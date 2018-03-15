<?php namespace App;

use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class PoweredByMiddleware
 * @package App
 */
class PoweredByMiddleware implements MiddlewareInterface {

  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) {
    $response = $handler->handle($request);
    return $response->withHeader('X-Powered-By', 'GC7');
  }
}
