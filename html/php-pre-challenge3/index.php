<?php
$limit = $_GET['target'];

$dsn = 'mysql:dbname=test;host=mysql';
$dbuser = 'test';
$dbpassword = 'test';

// 1以上の整数以外を400エラーで返す
if (!($limit >= 1)) {
    http_response_code(400);
}

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
$num_length = count($num);

// echo "<pre>";
// for ($i = 0; $i <= $length; $i++) {
//   echo $num[$i] . "<br>";
// }
// echo "</pre>";

// 組み合わせ列挙
$take = 2;
$comb_length = 0;

for ($i = 0; $i <= $num_length - $take; $i++) {
    for ($j = $i + 1; $j < $num_length; $j++) {
        $took[$comb_length] = [$num[$i], $num[$j]];
        $comb_length++;
    }
}

$take++;

for ($i = 0; $i <= $num_length - $take; $i++) {
    for ($j = $i + 1; $j < $num_length; $j++) {
        for ($k = $j + 1; $k < $num_length; $k++) {
            $took[$comb_length] = [$num[$i], $num[$j], $num[$k]];
            $comb_length++;
        }
    }
}

$take++;

for ($i = 0; $i <= $num_length - $take; $i++) {
    for ($j = $i + 1; $j < $num_length; $j++) {
        for ($k = $j + 1; $k < $num_length; $k++) {
            for ($l = $k + 1; $l < $num_length; $l++) {
                $took[$comb_length] = [$num[$i], $num[$j], $num[$k], $num[$l]];
                $comb_length++;
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
                    $took[$comb_length] = [$num[$i], $num[$j], $num[$k], $num[$l], $num[$m]];
                    $comb_length++;
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
                        $took[$comb_length] = [$num[$i], $num[$j], $num[$k], $num[$l], $num[$m], $num[$n]];
                        $comb_length++;
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
                            $took[$comb_length] = [$num[$i], $num[$j], $num[$k], $num[$l], $num[$m], $num[$n], $num[$o]];
                            $comb_length++;
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
                                $took[$comb_length] = [$num[$i], $num[$j], $num[$k], $num[$l], $num[$m], $num[$n], $num[$o], $num[$p]];
                                $comb_length++;
                            }
                        }
                    }
                }
            }
        }
    }
}

// echo"<pre>";
// print_r($took);
// echo $comb_length;
// echo"</pre>";

// 組み合わせ照合
$y = 0;
settype($limit, "integer");
for ($x = 0; $x < $comb_length; $x++) {
    if ($limit === array_sum($took[$x])) {
        $hit_comb[$y] = $took[$x];
        $y++;
    }
}

echo"<pre>";
print_r($hit_comb);
echo"</pre>";
