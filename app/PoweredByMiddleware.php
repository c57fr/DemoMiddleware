<?php namespace App;

use Interop\Http\Server\RequestHandlerInterface;

/**
 * Class PoweredByMiddleware
 * @package App
 */
class PoweredByMiddleware {
  public function __invoke($request, $response, callable $next) {
    return $next($request, $response->withHeader('X-Powered-By', 'GC7'));
  }
}
