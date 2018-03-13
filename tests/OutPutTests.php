<?php namespace Gc7;

use PHPUnit\Framework\TestCase;

class OutputTest extends TestCase {
  public function testExpectFooActualFoo() {
    $this->expectOutputString('foo');
    print 'foo';
  }

  public function testExpectBarActualBaz() {
    $this->expectOutputString('bar');
    print 'bar';
  }

  public function testEquality() {
    $this->assertSame(
      [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 3, 4, 5, 6],
      [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 3, 4, 5, 6]
    );
  }

  /**
   * @dataProvider provider
   */
  public function testMethod($data) {
    $this->assertTrue($data);
  }

  public function provider() {
    return [
      'my named data' => [true],
      'my data'       => [true]
    ];
  }
}
