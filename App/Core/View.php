<?php
/* Shaoran web application framework 5 */
require_once 'App/Models/Vendor/autoload.php';

use eftec\bladeone\BladeOne;

class View
{
  private static $blade;
  private static $contentBundle = [
    'all.min.css',
    'animation.css',
    'bootstrap.min.css',
    'datepicker.css',
    'quill.core.css',
    'quill.snow.css',
    'site.main.css',
  ];
  private static $scriptBundle = [
    'jquery/jquery.min.js',
    'popper/popper.min.js',
    'parallax/parallax.min.js',
    'numeral/jquery.numeral.min.js',
    'bootstrap/bootstrap.min.js',
    'datepicker/bootstrap-datepicker.js',
    'datepicker/bootstrap-datepicker-thai.js',
    'datepicker/locales/bootstrap-datepicker.th.js',
    'dropzone/dropzone.min.js',
    'dropzone/component.fileupload.js',
    'bootbox/bootbox.min.js',
    'bootbox/bootbox.locales.min.js',
    'system/script.main.js',
  ];

  function __construct()
  {
    self::$blade = new BladeOne('./App/Views/');
  }

  public function Render($action = null, $controller = null, $data = [])
  {
    $url = HttpURL::Get();
    if ($controller == null)
    {
      $controller = RouteDefault['Controller'];
      if (!empty($url[0]) && file_exists('App/Views/'.ucfirst($url[0])))
        $controller = ucfirst($url[0]);
    }
    if ($action == null)
      $action = empty($url[1]) ? RouteDefault['Action'] : ucfirst($url[1]);
    $data['RenderBundle'] = $this->RenderBundle();
    return self::$blade->run("{$controller}/{$action}.html", $data);
  }

  public function Redirect($action = null, $controller = null, $id = [])
  {
    $path = [AssemblyBaseURL];
    if ($controller != null)
    {
      $path[] = strtolower($controller);
      if ($action != null)
      {
        $path[] = strtolower($action);
        if ($id != null && count($id) > 0)
          $path = array_merge($path, $id);
      }
    }
    header('location: '.join('/', $path));
    exit;
  }

  private function RenderBundle()
  {
    return join('', array_merge(array_map(function($v) {
      return '<script src="'.AssemblyBaseURL.'/scripts/'.$v.'"></script>';
    }, self::$scriptBundle), array_map(function($v) {
      return '<link type="text/css" rel="stylesheet" href="'.AssemblyBaseURL.'/content/'.$v.'">';
    }, self::$contentBundle)));
  }
}
?>
