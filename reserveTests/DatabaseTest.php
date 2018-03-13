<?php namespace Gc7;

use PDO;
use PHPUnit\Framework\TestCase;

require 'vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

class DatabaseTest extends TestCase {
  protected static $dbh;
  private static   $db_name = 'pooga';
  private static   $db_user = 'root';
  private static   $db_host = 'localhost';
  private static   $db_pass = '';
  private          $rep;

  public static function setUpBeforeClass() {
    if (self::$dbh === null) {
      $pdo = new PDO("mysql:dbname=" . self::$db_name . ";host=" . self::$db_host, self::$db_user, self::$db_pass);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$dbh = $pdo;
    }

    return self::$dbh;
  }

  public function testUsernameField() {
    $dbh = self::$dbh;
    $sql = 'SELECT  * FROM users WHERE id=?';
    $stmt = $dbh->prepare($sql);
    $stmt->execute([1]);
    $rep = $stmt->fetch(PDO::FETCH_ASSOC);
    assertTrue(1 == 1);
    assertArrayHasKey('username', $rep);
    return $rep;
  }

  /**
   * @depends testUsernameField
   */
  public function testUser1($rep) {
    assertEquals('demo', $rep['username']);
  }

  public static function tearDownAfterClass() {
    self::$dbh = null;
  }
}

// Qd ce fichier est dans tests, sinon adapter
// Soit, déplacer ce ficher dans tests, soit changer commande
// Console: phpunit tests/DatabaseTest --debug
