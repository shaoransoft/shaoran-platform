<?php
/* Shaoran web application framework 5 */
class HttpURL {
  public static function Get() {
    return isset($_GET['url']) ? explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)) : [];
  }
}
?>
