<?php
/* Shaoran web application framework 5 */
class UserAuth {
  private static $parent = 'AUTH';

  private function GetParent() {
    return isset($_SESSION[self::$parent]) ? $_SESSION[self::$parent] : null;
  }

  public function Get($p = false) {
    if ($this->IsActive())
      return $this->HasParam($p) ? $this->GetParam($p) : null;
    return null;
  }

  public function Set($p = false, $v = null) {
    if (is_array($p)) {
      foreach ($p as $param => $val) {
        $this->SetParam($param, $val);
      }
    }
    else $this->SetParam($p, $v);
  }

  private function SetParam($p, $v) {
    $_SESSION[self::$parent][$p] = $v;
  }

  private function GetParam($p) {
    return isset($p) ? $this->GetParent()[$p] : $this->GetParent();
  }

  private function HasParam($p) {
    return isset($this->GetParent()[$p]);
  }

  public function IsActive() {
    return $this->GetParent() !== null;
  }

  public function Active() {
    if (!$this->IsActive()) View::Redirect('signin', 'auth');
  }

  public function ApiActive() {
    if (!$this->IsActive()) API::Response(401);
  }

  public function Forget() {
    session_destroy();
  }
}
?>
