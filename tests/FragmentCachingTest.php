<?php
use Gc7\FragmentCaching;
use Gc7\CacheAdapterInterface;
use PHPUnit\Framework\TestCase;

class FakeCacheAdapter implements CacheAdapterInterface {
  public function get($key) {
    return FALSE;
  }

  public function set($key, $value) {
//    $this->$key=$value;
  }
}

class FakeModel {
  private $key;

  public function __construct($key) {
    $this->key = $key;
  }

  public function cache_key():string {
    return $this->key;
  }

  public function __toString():string {
    return $this->cache_key();
  }
}

class FragmentCachingTest extends TestCase {

  public function testCacheWithCache() {
    $cache = $this->getInstanceWithOutExpectedGet('en cache');

    $this->expectOutputString('en cache');

    $cache->cache('testCache', function () {
      echo 'Salut !';
    });
  }

  public function testCacheWithOutCache() {

    $cache = $this->getInstanceWithOutExpectedGet();

    $this->expectOutputString('Salut !');

    $cache->cache('testCache', function () {
      echo 'Salut !';
    });
  }

  public function testCacheWithoutCacheSetCache() {

    $cacheAdapter = $this->getMockBuilder(FakeCacheAdapter::class)
      ->setMethods(['get', 'set'])
      ->getMock();
    $cacheAdapter->method('get')->willReturn(FALSE);

    $cacheAdapter->expects($this->once())->method('set')->with('testCache', 'Salut !');

    $cache = new FragmentCaching($cacheAdapter);
    $cache->cache('testCache', function () {
      echo 'Salut !';
    });

  }

  public function testKeyWithArray() {
    $cache = $this->getInstanceWithExpectedGet('test-je-suis');
    $cache->cache(['test', 'je', 'suis'], function () {
      return FALSE;
    });
  }

  public function testKeyWithBooleanTrue() {
    $cache = $this->getInstanceWithExpectedGet('test-1-suis');
    $cache->cache(['test', TRUE, 'suis'], function () {
      return FALSE;
    });
  }

  public function testKeyWithBooleanFalse() {
    $cache = $this->getInstanceWithExpectedGet('test-0-suis');
    $cache->cache(['test', FALSE, 'suis'], function () {
      return FALSE;
    });
  }

  public function testKeyWithObject() {

    $fake = new FakeModel('model');
    $cache = $this->getInstanceWithExpectedGet('test-model-suis');
    $cache->cache(['test', $fake, 'suis'], function () {
      return FALSE;
    });
  }

  public function getInstanceWithOutExpectedGet($value = FALSE) {
    $cacheAdapter = $this->getMockBuilder(FakeCacheAdapter::class)
      ->setMethods(['get'])
      ->getMock();
    $cacheAdapter->method('get')->willReturn($value);

    return new FragmentCaching($cacheAdapter);
  }

  public function getInstanceWithExpectedGet($value = FALSE) {
    $cacheAdapter = $this->getMockBuilder(FakeCacheAdapter::class)
      ->setMethods(['get'])
      ->getMock();

    $cacheAdapter->expects($this->once())->method('get')->with($value);

    return new FragmentCaching($cacheAdapter);
  }

}

