<?php namespace Gc7;

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase {
  protected static $dbh;
  private static   $db_name = 'pooga';
  private static   $db_user = 'root';
  private static   $db_host = 'localhost';
  private static   $db_pass = '';

  public static function setUpBeforeClass() {
    if (self::$dbh === null) {
      $pdo = new \PDO("mysql:dbname=" . self::$db_name . ";host=" . self::$db_host, self::$db_user, self::$db_pass);
      $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      self::$dbh = $pdo;
    }

    return self::$dbh;
  }

  public function testUsers() {
    $pdo = self::$dbh;
    $sql = 'SELECT * FROM users';
    $pdo = $pdo->query($sql);
    $rep = $pdo->fetchAll();
    var_dump($rep);
    $this->assertArrayHasKey('username', $rep[0]);
    $this->assertEquals('demo', $rep[0]['username']);
  }


  public static function tearDownAfterClass() {
    self::$dbh = null;
  }
}
