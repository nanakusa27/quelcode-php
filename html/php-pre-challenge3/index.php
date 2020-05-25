<?php
$limit = $_GET['target'];

$dsn = 'mysql:dbname=test;host=mysql';
$dbuser = 'test';
$dbpassword = 'test';

// 例外処理、1以上の整数以外を400エラーで返す
if (!($limit >= 1)) {
    http_response_code(400);
    exit();
}

// DB接続
try {
  $db = new PDO($dsn, $dbuser, $dbpassword);
} catch (PDOException $e) {
  echo 'DB接続エラー：' . $e->getMessage();
}

// 値取り出し
$numbers = $db->query('SELECT value FROM prechallenge3');

for ($i = 0; $number = $numbers->fetch(); $i++) {
  // print($number['value']);
  $num[$i] = (int)$number['value'];
}
$num_length = count($num);

// echo "<pre>";
// for ($i = 0; $i <= $length; $i++) {
//   echo $num[$i] . "<br>";
// }
// echo "</pre>";

// 組み合わせ列挙
function getCpattern($num, $take) {
// 引数 $num：選択元要素の配列
// 引数 $take：$num から異なる $take 個を選ぶ

    $num_length = count($num);
    return ptn($num, $num_length, array(), 0, $num_length - $take + 1);
}

// ptn：内部で再帰的に呼び出される関数
function ptn($num, $num_length, $subset, $begin, $end) {
    $p = array();
    for ($i = $begin; $i < $end; $i++) {
        // print_r($num[$i] . ",");
        $tmp = array_merge($subset, (array)$num[$i]);
        // print_r($tmp);
        if ($end + 1 <= $num_length) {
            $p = array_merge($p, ptn($num, $num_length, $tmp, $i + 1, $end + 1));
        } else {
            array_push($p, $tmp);
        }
    }
    return $p;
}

$p =array();
for ($j = 2; $j <= count($num); $j++) {
    array_push($p, getCpattern($num, $j));
}

// echo"<pre>";
// print_r($p);
// echo"</pre>";

// ２次元配列を一つの配列に組み合わせ列挙を入れ直す
$comb_cnt = 0;
foreach ($p as $comb) {
    foreach ($comb as $c) {
        $combination[$comb_cnt] = $c;
        $comb_cnt++;
    }
}

// 組み合わせ照合
$y = 0;
settype($limit, "integer");
for ($x = 0; $x < $comb_cnt; $x++) {
    if ($limit === array_sum($combination[$x])) {
        $hit_comb[$y] = $combination[$x];
        $y++;
    }
}

// echo"<pre>";
// print_r($hit_comb);
// echo"</pre>";

// 例外処理、組み合わせが存在しない場合
if (is_null($hit_comb)) {
    $hit_comb = [];
}

// jsonにエンコードし、出力
$json = json_encode($hit_comb);
echo $json;
