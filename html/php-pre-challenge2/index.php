<?php
$array = explode(',', $_GET['array']);

// 修正はここから
$length = count($array);

for ($i = 0; $i < $length - 1; $i++) {
  for ($n = $i + 1; $n < $length; $n++) {
    if ($array[$i] > $array[$n]) {
      $tmp = $array[$i];
      $array[$i] = $array[$n];
      $array[$n] = $tmp;
    }
  }
}
// 修正はここまで

echo "<pre>";
print_r($array);
echo "</pre>";
