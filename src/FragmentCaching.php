<?php namespace Gc7;
use App\CacheAdapterInterface;


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

  private function hashKeys($keys) {
    if (is_string($keys)) {
      return $keys;
    } else {
      $return = [];
      foreach ($keys as $k) {
        array_push($return,
                   $this->hashkey($k));
      }
      return implode('-', $return);
    }
  }

  private function hashKey($key) {
    if (is_bool($key))
      return $key ? 1 : 0;
    else return $key;
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

  public function cacheIf($condition, $key, Callable $callback) {
    if ($condition === FALSE)
      $callback();
    else
      $this->cache($key, $callback);
  }
}
