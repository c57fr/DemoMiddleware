<?php namespace Test;

use App\CsrfMiddleware;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class CsrfMiddlewareTest extends TestCase {

  public function makeRequest($method = 'GET'):ServerRequestInterface {
    $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
    $request->method('getMethod')->willReturn($method);
    return $request;
  }

  public function makeDelegate() : DelegateInterface {
    $delegate = $this->getMockBuilder(DelegateInterface::class)->getMock();
    $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
    $delegate->method('process')->willReturn($response);
    return $request;

  }

  public function testGetPass() {
    $middleware = new CsrfMiddleware();
    $delegate = $this->makeDelegate();
    $delegate->method('process')->expects($this->once());
    $middleware->process($this->makeRequest('GET'),
      $delegate
    );
  }

  public function testPreventPost() {
    $middleware = new CsrfMiddleware();
    $delegate = $this->makeDelegate();
    $delegate->method('process')->expects($this->never());
    $this->expectException(\Exception::class);
    $middleware->process($this->makeRequest('POST'),
      $delegate
    );
  }


}
