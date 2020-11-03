<?php
/* Shaoran web application framework 5 */
class UserAuth {
  private static $parent = 'AUTH';

  public function Get($param = false) {
    return ($param) ? $_SESSION[static::$parent][$param] : $_SESSION[static::$parent];
  }

  public function Set($param = false, $value = null) {
    if (is_array($param))
      $_SESSION[self::$parent] = $param;
    else
      $_SESSION[self::$parent][$param] = $value;
  }

  public function IsActive() {
    return isset($_SESSION[self::$parent]);
  }

  public function Active() {
    if (!$this->IsActive()) View::Redirect('signin', 'auth');
  }

  public function ApiActive() {
    if (!$this->IsActive()) API::Response(403);
  }

  public function Forget() {
    session_destroy();
  }
}
?>
