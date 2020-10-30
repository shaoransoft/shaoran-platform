<?php
class Convert {
  public static function StrlenUTF8($s) {
    $l = 0;
    for ($i = 0; $i < strlen($s); ++$i) if ((ord($s[$i]) & 0xC0) != 0x80) ++$l;
    return $l;
  }

  public static function S0($n, $l = 2) {
    return sprintf("%0{$l}d", $n);
  }

  public static function StrToDate($s) {
    $d = explode('/', $s);
    $dc = date_create($d[2].'-'.$d[1].'-'.$d[0]);
    return date_format($dc, 'Y-m-d');
  }

  public static function DateToStr($d) {
    if ($d != '0000-00-00 00:00:00') {
      $dc = date_create($d);
      return date_format($dc, 'd/m/Y');
    }
    return '';
  }
}
?>
