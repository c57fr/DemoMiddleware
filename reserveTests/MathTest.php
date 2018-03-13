<?php

use Gc7\Math;
use PHPUnit\Framework\TestCase;

class MathTest extends TestCase {

  public static function testStaticDouble() {
    self::assertEquals(4,Math::double(2));
  }

  public function testDouble() {
    $this->assertEquals(4,Math::double(2));
  }

}
