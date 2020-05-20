<?php
$limit = $_GET['target'];

$dsn = 'mysql:dbname=test;host=mysql';
$dbuser = 'test';
$dbpassword = 'test';

// DB接続
try {
  $db = new PDO($dsn, $dbuser, $dbpassword);
} catch (PDOException $e) {
  echo 'DB接続エラー：' . $e->getMessage();
}

$numbers = $db->query('SELECT value FROM prechallenge3');

$i = 0;
while($number = $numbers->fetch()) {
  // print($number['value']);
  $num[$i] = $number['value'];
  $i++;
}
$length = count($num);

// echo "<pre>";
// for ($i = 0; $i <= $length; $i++) {
//   echo $num[$i] . "<br>";
// }
// echo "</pre>";