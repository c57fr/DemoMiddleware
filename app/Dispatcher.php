<?php namespace App;

use GuzzleHttp\Psr7\Response;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
//use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class Dispatcher
 * @property Response response
 * @package App
 *
 * @code Coverage Ignore
 */
class Dispatcher implements RequestHandlerInterface{
  /**
   * @var array
   */
  private $middlewares = [];
  /**
   * @var int
   */
  private $index = 0;
  /**
   * @var Response
   */
  private $response;

  /**
   * Permet d'enregistrer un nouveau middleware
   *
   * @param callable|MiddlewareInterface $middleware
   */
  public function pipe($middleware) {
    $this->middlewares[] = $middleware;
    $this->response = new Response();
  }

  /**
   * Permet d'éxecuter les middlewares
   *
   * @param ServerRequestInterface $request
   * @param ResponseInterface $response
   * @return ResponseInterface
   */
  public function process(ServerRequestInterface $request): ResponseInterface {
    $middleware = $this->getMiddleware();
    $this->index++;
    if (is_null($middleware))
      return $this->response;
    if (is_callable($middleware))
      return $middleware($request, $this->response, [$this, 'process']);
    elseif ($middleware instanceof MiddlewareInterface)
      return $middleware->process($request, $this);
  }

  private function getMiddleware() {
    // todoli test ??
    if (isset($this->middlewares[$this->index]))
      return $this->middlewares[$this->index];
    return null;
  }

  /**
   * Handle the request and return a response.
   *
   * @param ServerRequestInterface $request
   *
   * @return ResponseInterface
   */
  public function handle(ServerRequestInterface $request):ResponseInterface {
    $middleware = $this->getMiddleware();
    $this->index++;
    if (is_null($middleware))
      return $response;
    if (is_callable($middleware))
      return $middleware($request, $response, [$this, 'process']);
    elseif ($middleware instanceof MiddlewareInterface)
      return $middleware->handle($request, $this);
  }
}
