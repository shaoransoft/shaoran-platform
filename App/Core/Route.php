<?php
/* Shaoran web application framework 5 */
require_once 'App/WebConfig.php';
require_once 'App/Models/HttpURL.php';
require_once 'App/Models/API.php';

class Route
{
  protected $method = RouteApiDefault['Method'];
  protected $controller = RouteDefault['Controller'];
  protected $action = RouteDefault['Action'];
  protected $params = [];

  public function __construct()
  {
    new Controller;
    $url = HttpURL::Get();
    if (empty($url[0]))
      $url[0] = $this->controller;
    if (strtolower($url[0]) === 'api')
      $this->RouteAPI($url);
    else
      $this->RouteController($url);
    if (!empty($_POST))
      $_POST = $this->RecheckRequest($_POST);
    if (!empty($_GET))
      $_GET = $this->RecheckRequest($_GET);
    call_user_func_array([$this->controller, $this->action], $this->RecheckRequest($this->params));
  }

  private function RecheckRequest($req = [])
  {
    if ($req != null && is_array($req))
    {
      return array_combine(array_keys($req), array_map(function($v) {
        return is_array($v) ? $this->RecheckRequest($v) : htmlentities($v);
      }, $req));
    }
    return $req;
  }

  private function RouteController($url = null)
  {
    $controller = ucfirst($url[0]).'Controller';
    if (file_exists('App/Controllers/'.$controller.'.php'))
    {
      $this->controller = $controller;
      unset($url[0]);
    }
    else $this->controller = $this->controller.'Controller';
    require_once 'App/Controllers/'.$this->controller.'.php';
    $this->controller = new $this->controller;

    if (isset($url[1]))
    {
      $action = ucfirst($url[1]);
      if (method_exists($this->controller, $action))
      {
        $this->action = $action;
        unset($url[1]);
      }
      if (!empty($url))
        array_push($this->params, array_values($url));
    }
  }

  private function RouteAPI($url = null)
  {
    unset($url[0]);
    $this->method = RouteApiDefault['Method'];
    $this->action = RouteApiDefault['Action'];

    if (!isset($url[1]))
      API::Response(400);
    $method = strtoupper($url[1]);
    if (!in_array($method, ['GET','POST','PUT','DELETE']))
      API::Response(400);
    $this->method = $method;
    unset($url[1]);

    if (!isset($url[2]))
      API::Response(400);
    $controller = ucfirst($url[2]).'Api';
    if (!file_exists('App/Controllers/api/'.$controller.'.php'))
      API::Response(404);
    $this->controller = $controller;
    unset($url[2]);
    require_once 'App/Controllers/api/'.$this->controller.'.php';
    $this->controller = new $this->controller;


    $action = $this->method.'_'.(isset($url[3]) ? ucfirst($url[3]) : $this->action);
    if (!method_exists($this->controller, $action))
      API::Response(400);
    $this->action = $action;
    if (isset($url[3]))
      unset($url[3]);
    if (!empty($url))
      array_push($this->params, array_values($url));
  }
}
?>
