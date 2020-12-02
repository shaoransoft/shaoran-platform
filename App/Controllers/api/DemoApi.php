<?php
class DemoApi extends Controller
{
  function __construct()
  {
    self::$model->userAuth->ApiActive();
  }

  public function GET_Index($req = null)
  {
    API::Response(200);
  }

  public function POST_Index($req = null)
  {
    API::Response(200);
  }

  public function PUT_Index($req = null)
  {
    API::Response(200);
  }

  public function DELETE_Index($req = null)
  {
    API::Response(200);
  }
}
?>
