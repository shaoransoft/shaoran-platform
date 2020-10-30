<?php
class User extends Model
{
  function __construct()
  {
    self::$db->Connect(Db['Default']);
  }

  public function GetUsers($req = null)
  {
    self::$db->Select('tb_user');
    self::$db->Where([
      'UserIdx' => isset($req['UserIdx']) ? $req['UserIdx'] : null,
      'UserGroupIdx' => isset($req['UserGroupIdx']) ? $req['UserGroupIdx'] : null,
      'UserType' => isset($req['UserType']) ? $req['UserType'] : null,
    ]);
    self::$db->OrderBy(['UserIdx' => 'asc']);
    return self::$db->Execute();
  }
}
?>
