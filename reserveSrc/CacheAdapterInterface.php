<?php namespace Gc7;


interface CacheAdapterInterface {
  public function get($key);
  public function set($key, $value);
}
