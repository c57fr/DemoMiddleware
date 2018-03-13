<?php namespace Gc7;

use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase {

  public function testPageTitle():void {
    $this->assertEquals('Titre de ma page',
      Functions::pageTitle());
  }

}
