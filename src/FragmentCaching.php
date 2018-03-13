<?php namespace Gc7;


/**
 * Class FragmentCaching
 * @package Gc7
 */
class FragmentCaching {
  /**
   * @var
   */
  private $cache;

  /**
   * FragmentCaching constructor.
   *
   * @param StdClass $param
   */
  public function __construct(CacheAdapterInterface $cache) {
    $this->cache = $cache;
  }

  private function hashKeys($key) {
    if (is_string($key)) {
      return $key;
    } else {
      return implode('-', $key);
    }
  }


  public function cache($key, callable $callback) {
    $key = $this->hashKeys($key);
    $value = $this->cache->get($key);
    if (!$value) {
      ob_start();
      $callback();
      $value = ob_get_clean();
      $this->cache->set($key, $value);
    }
    echo $value;
  }

}
