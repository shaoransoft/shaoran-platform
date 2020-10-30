<?php
/* Shaoran web application framework 5 */
session_name(hash('sha256', AssemblyBaseURL));
session_start();
date_default_timezone_set(TimeZone);

class Controller
{
  protected static $model;
  protected static $view;
  protected static $session;

  function __construct()
  {
    self::$model = new Model;
    self::$view = new View;
  }

  protected function View($viewData = [], $viewPage = [], $action = null, $controller = null)
  {
    $session = self::$model->userAuth->Get();
    if (!empty(self::$session))
      $session['Info'] = self::$session;
    $viewData = array_merge($viewData != null ? $viewData : [], [
      'Session' => $session,
    ]);

    $dataSet = [
      'ViewPage' => $this->ViewPage($viewPage),
      'ViewData' => $viewData,
      'System' => $this->System(),
      'NavIsActive' => $this->NavIsActive(),
      'RenderOverlay' => self::$view->Render('_Overlay', 'Shared')
    ];
    echo self::$view->Render('_Layout', 'Shared', array_merge($dataSet, [
      'RenderNav' => self::$view->Render('_Nav', 'Shared', $dataSet),
      'RenderBody' => self::$view->Render($action, $controller, $dataSet),
      'RenderFooter' => self::$view->Render('_Footer', 'Shared', $dataSet),
    ]));
  }

  private function ViewPage($viewPage = null)
  {
    $viewPage['Title'] = isset($viewPage['Title']) ? $viewPage['Title'] : AssemblyTitle;
    $viewPage['Description'] = isset($viewPage['Description']) ? $viewPage['Description'] : AssemblyDescription;
    $viewPage['Keywords'] = isset($viewPage['Keywords']) ? $viewPage['Keywords'] : AssemblyKeywords;
    return $viewPage;
  }

  private function System()
  {
    $url = HttpURL::Get();
    return [
      'AssemblyInfo' => [
        'Title' => AssemblyTitle,
        'BaseURL' => AssemblyBaseURL,
        'Description' => AssemblyDescription,
        'Keywords' => AssemblyKeywords,
        'Author' => AssemblyAuthor,
        'Copyright' => AssemblyCopyright,
        'Trademark' => AssemblyTrademark,
        'Version' => AssemblyVersion
      ],
      'Controller' => isset($url[0]) ? $url[0] : null,
      'Action' => isset($url[1]) ? $url[1] : null
    ];
  }

  private function NavIsActive()
  {
    $controller = strtolower($this->System()['Controller']);
    $action = strtolower($this->System()['Action']);
    if ($controller !== 'account')
      session_destroy();
    return [
      'P_HOME' => $controller === 'home',
    ];
  }
}
?>
