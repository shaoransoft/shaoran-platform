<?php
/* Shaoran web application framework 5 */
class UserAuth {
  private static $session = null;
  private static $param = 'USER_SIGN_IN';

  function __construct() {
    if (isset($_SESSION[self::$param])) self::$session = $_SESSION[self::$param];
  }

  public function Get() {
    return self::$session;
  }

  public function Set($session = null) {
    $_SESSION[self::$param] = $session;
  }

  public function Active() {
    if (!isset(self::$session)) View::Redirect('SignIn', 'Account');
  }

  public function ApiActive() {
    if (!isset(self::$session)) API::Response(403);
  }
}
?>
