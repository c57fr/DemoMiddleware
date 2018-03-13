<?php
use Gc7\CsvFileIterator;
use PHPUnit\Framework\TestCase;


class DataTest extends TestCase {
  /**
   * @dataProvider additionProvider
   * @dataProvider additionProvider2
   */
  public function testAdd($a, $b, $expected) {
    $this->assertSame((int)$expected, $a + $b);
  }

  public function additionProvider() {
    return [
      'adding zeros'  => [0, 0, 0],
      'zero plus one' => [0, 1, 1],
      'one plus zero' => [1, 0, 1],
      'one plus one'  => [1, 2, 3]
    ];
  }

  public function additionProvider2() {
    $data = new CsvFileIterator('src/data.csv');
    var_dump($data->file);
    return $data;
  }
}
