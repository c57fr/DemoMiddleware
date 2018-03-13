<?php namespace Gc7;


use PHPUnit\Framework\TestCase;

class InexistingFileIncludeTest extends TestCase {


  /**
   * @expectedException PHPUnit\Framework\Error\Error
   */
  public function testFailingInclude() {
    include 'not_existing_file.php';
  }
  /**
   * @expectedException PHPUnit\Framework\Error\Error
   */
  public function testFailMathOperation() {
    $a = 4/0;
  }

}
