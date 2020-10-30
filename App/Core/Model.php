<?php
/* Shaoran web application framework 5 */
require_once 'App/Models/DbHelper.php';
require_once 'App/Models/UserAuth.php';

class Model
{
  protected static $db;
  public $userAuth;

  function __construct()
  {
    self::$db = new DbHelper;
    $this->userAuth = new UserAuth;
  }
}
?>
