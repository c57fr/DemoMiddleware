<?php

use Gc7\Math;
use PHPUnit\Framework\TestCase;

require 'vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

class BasicMathTest extends TestCase {

  public function testBasicOperation() {
    $this->assertEquals(1 + 1, '2');
    $this->assertNotSame(2, '2');
  }

  public static function testStaticDouble() {
    self::assertEquals(4, Math::double(2));
  }

  public function testDouble() {
    $this->assertEquals(5, Math::double(2.5));
  }

  public function testDoubleIfZeroParFonction() {
    assertEquals(0, Math::double(0));
  }

}
