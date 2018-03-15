<?php namespace Test;

use Gc7\CsrfMiddleware;
use PHPUnit\Framework\TestCase;

class CsrfMiddlewareTest extends TestCase {

  public function makeDelegate() :DelegateInterface {
    $delegate = $this->getMockBuilder(DelegateInterface::class)->getMock();
    $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
    $delegate->method('process')->willReturn($response);
    return $delegate;
  }

  public function testGetPasses() {
    $middleware = new CsrfMiddleware();
    $delegate = $this->makeDelegate();

    $delegate->expects($this->once())->method('process');

    $middleware->process($this->makeRequest('GET'),
                         $delegate
    );
  }

  public function otestPreventPost() {
//    $middleware = new CsrfMiddleware();
//    $delegate = $this->makeDelegate();
//    $delegate->expects($this->never())->method('process');
//    $this->expectException(\Exception::class);
//    $middleware->process($this->makeRequest('POST'),
//                         $delegate
//    );
  }

}
