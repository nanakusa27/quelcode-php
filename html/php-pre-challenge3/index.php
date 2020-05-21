<?php
$limit = $_GET['target'];

$dsn = 'mysql:dbname=test;host=mysql';
$dbuser = 'test';
$dbpassword = 'test';

// 1以上の整数以外を400エラーで返す
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
$take = 2;
$comb_cnt = 0;

for ($i = 0; $i <= $num_length - $take; $i++) {
    for ($j = $i + 1; $j < $num_length; $j++) {
        $combination[$comb_cnt] = [$num[$i], $num[$j]];
        $comb_cnt++;
    }
}

$take++;

for ($i = 0; $i <= $num_length - $take; $i++) {
    for ($j = $i + 1; $j < $num_length; $j++) {
        for ($k = $j + 1; $k < $num_length; $k++) {
            $combination[$comb_cnt] = [$num[$i], $num[$j], $num[$k]];
            $comb_cnt++;
        }
    }
}

$take++;

for ($i = 0; $i <= $num_length - $take; $i++) {
    for ($j = $i + 1; $j < $num_length; $j++) {
        for ($k = $j + 1; $k < $num_length; $k++) {
            for ($l = $k + 1; $l < $num_length; $l++) {
                $combination[$comb_cnt] = [$num[$i], $num[$j], $num[$k], $num[$l]];
                $comb_cnt++;
            }
        }
    }
}

$take++;

for ($i = 0; $i <= $num_length - $take; $i++) {
    for ($j = $i + 1; $j < $num_length; $j++) {
        for ($k = $j + 1; $k < $num_length; $k++) {
            for ($l = $k + 1; $l < $num_length; $l++) {
                for ($m = $l + 1; $m < $num_length; $m++) {
                    $combination[$comb_cnt] = [$num[$i], $num[$j], $num[$k], $num[$l], $num[$m]];
                    $comb_cnt++;
                }
            }
        }
    }
}

$take++;

for ($i = 0; $i <= $num_length - $take; $i++) {
    for ($j = $i + 1; $j < $num_length; $j++) {
        for ($k = $j + 1; $k < $num_length; $k++) {
            for ($l = $k + 1; $l < $num_length; $l++) {
                for ($m = $l + 1; $m < $num_length; $m++) {
                    for ($n = $m + 1; $n < $num_length; $n++) {
                        $combination[$comb_cnt] = [$num[$i], $num[$j], $num[$k], $num[$l], $num[$m], $num[$n]];
                        $comb_cnt++;
                    }
                }
            }
        }
    }
}

$take++;

for ($i = 0; $i <= $num_length - $take; $i++) {
    for ($j = $i + 1; $j < $num_length; $j++) {
        for ($k = $j + 1; $k < $num_length; $k++) {
            for ($l = $k + 1; $l < $num_length; $l++) {
                for ($m = $l + 1; $m < $num_length; $m++) {
                    for ($n = $m + 1; $n < $num_length; $n++) {
                        for ($o = $n + 1; $o < $num_length; $o++) {
                            $combination[$comb_cnt] = [$num[$i], $num[$j], $num[$k], $num[$l], $num[$m], $num[$n], $num[$o]];
                            $comb_cnt++;
                        }
                    }
                }
            }
        }
    }
}

$take++;

for ($i = 0; $i <= $num_length - $take; $i++) {
    for ($j = $i + 1; $j < $num_length; $j++) {
        for ($k = $j + 1; $k < $num_length; $k++) {
            for ($l = $k + 1; $l < $num_length; $l++) {
                for ($m = $l + 1; $m < $num_length; $m++) {
                    for ($n = $m + 1; $n < $num_length; $n++) {
                        for ($o = $n + 1; $o < $num_length; $o++) {
                            for ($p = $o + 1; $p < $num_length; $p++) {
                                $combination[$comb_cnt] = [$num[$i], $num[$j], $num[$k], $num[$l], $num[$m], $num[$n], $num[$o], $num[$p]];
                                $comb_cnt++;
                            }
                        }
                    }
                }
            }
        }
    }
}

// echo"<pre>";
// print_r($combination);
// echo $comb_cnt;
// echo"</pre>";

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

if (is_null($hit_comb)) {
    $hit_comb = [];
}

$json = json_encode($hit_comb);
echo $json;
