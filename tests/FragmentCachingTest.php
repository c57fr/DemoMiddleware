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

class FragmentCachingTest extends TestCase {

  public function testCacheWithCache() {
    $cacheAdapter = $this->getMockBuilder(FakeCacheAdapter::class)
      ->setMethods(['get'])
      ->getMock();
    $cacheAdapter->method('get')->willReturn('en cache');

    $cache = new FragmentCaching($cacheAdapter);

    $this->expectOutputString('en cache');

    $cache->cache('testCache', function () {
      echo 'Salut !';
    });
  }

  public function testCacheWithOutCache() {
    $cacheAdapter = $this->getMockBuilder(FakeCacheAdapter::class)
      ->setMethods(['get'])
      ->getMock();
    $cacheAdapter->method('get')->willReturn(False);

    $cache = new FragmentCaching($cacheAdapter);

    $this->expectOutputString('Salut !');

    $cache->cache('testCache', function () {
      echo 'Salut !';
    });
  }

  public function testCacheWithoutCacheSetCache() {

    $cacheAdapter = $this->getMockBuilder(FakeCacheAdapter::class)
      ->setMethods(['get', 'set'])
      ->getMock();
    $cacheAdapter->method('get')->willReturn(false);

    $cacheAdapter->expects($this->once())->method('set')->with('testCache', 'Salut !');

    $cache = new FragmentCaching($cacheAdapter);
    $cache->cache('testCache', function () {
      echo 'Salut !';
    });

  }
  

}

