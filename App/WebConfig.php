<?php
/* Shaoran web application framework 5 */
define('Db', [
  'Default' => [
    'Dsn' => 'mysql:host=localhost;dbname=YOUR_DATABASE;charset=utf8',
    'Username' => 'root',
    'Password' => '',
  ],
]);
define('AssemblyTitle', 'Shaoran Platform 5');
define('AssemblyBaseURL', 'http://localhost/shaoran-platform');
define('AssemblyDescription', 'Shaoran Platform');
define('AssemblyKeywords', 'Shaoran Platform, MVC');
define('AssemblyAuthor', 'Sr.');
define('AssemblyCopyright', 'Shaoransoft');
define('AssemblyTrademark', 'Shaoransoft');
define('AssemblyVersion', '5.0.0');
define('TimeZone', 'Asia/Bangkok');
define('DateTimeFormat', 'd/m/Y H:i:s');
define('DateFormat', 'd/m/Y');
define('TimeFormat', 'H:i:s');
define('MonthShortEng', ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']);
define('MonthLongEng', ['January','February','March','April','May','June','July','August','September','October','November','December']);
define('MonthShortTha', ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']);
define('MonthLongTha', ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฏาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม']);
define('RouteDefault', [
  'Controller' => 'Home',
  'Action' => 'Index'
]);
define('RouteApiDefault', [
  'Method' => 'GET',
  'Action' => 'Index'
]);
?>
