<?php
use Gc7\CsvFileIterator;
use PHPUnit\Framework\TestCase;


/**
 * Class DataTest
 */
class DataTest extends TestCase {
  /**
   * @dataProvider additionProvider
   * @dataProvider additionProvider2
   *
   * @param $a
   * @param $b
   * @param $expected
   */
  public function testAdd($a, $b, $expected) {
    static::assertSame((int)$expected, $a + $b);
  }

  /**
   * @return array
   */
  public function additionProvider() {
    return [
      'adding zeros'  => [0, 0, 0],
      'zero plus one' => [0, 1, 1],
      'one plus zero' => [1, 0, 1],
      'one plus one'  => [1, 2, 3]
    ];
  }

  /**
   * @return CsvFileIterator
   */
  public function additionProvider2() {
    return new CsvFileIterator('src/data.csv');
  }
}
