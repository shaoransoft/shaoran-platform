<?php
class Demo extends Controller
{
  function __construct()
  {
    self::$model->userAuth->ApiActive();
  }

  public function Index($req = null)
  {
    API::Response(200);
  }
}
?>
