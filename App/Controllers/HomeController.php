<?php
//require_once 'App/Models/Db/UserModel.php';

class Home extends Controller
{
  function __construct()
  {
  }

  public function Index($req = null)
  {
    //$user = new User;
    //$aa = $user->GetUsers();
    $this->View();
  }
}
?>
