<?php
/* Shaoran web application framework 5 */
class API {
  private static $httpStatusCode = [
    200 => 'success',
    201 => 'success',
    204 => 'success',
    304 => 'not modified',
    400 => 'bad request',
    401 => 'unauthorized',
    403 => 'forbidden',
    404 => 'not found',
    405 => 'gone',
    500 => 'internal server error',
    503 => 'service unavailable',
  ];

  public function Response($status = null, $content = null) {
    $httpResCode = self::$httpStatusCode;
    $res = [
      'status' => $status,
      'msg' => $httpResCode[array_key_exists($status, $httpResCode) ? $status : 400]
    ];
    if ($content != null) $res['content'] = $content;
    echo json_encode($res);
    exit;
  }
}
?>
