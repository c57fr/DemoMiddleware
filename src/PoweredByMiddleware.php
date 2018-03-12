<?php namespace App;

use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class PoweredByMiddleware
 * @package App
 */
class PoweredByMiddleware implements MiddlewareInterface {
    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) {
        $response = $handler->handle($request);
        $response->withHeader('X-Powered-By', 'GC7');
    }
}
