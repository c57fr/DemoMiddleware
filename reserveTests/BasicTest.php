<?php namespace Gc7;


use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase{

  public function testBasicOperation() {
    $this->assertEquals(1+1,'2');
    $this->assertNotSame(1+1,'2');
  }

}
