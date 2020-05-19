<?php
$array = explode(',', $_GET['array']);

// 修正はここから
for ($i = 0; $i < count($array); $i++) {
  for ($n = $i+1; $n < count($array); $n++) {
    if ($array[$i] > $array[$n]) {
      $ex = $array[$i];
      $array[$i] = $array[$n];
      $array[$n] = $ex;
    }
  }
}
// 修正はここまで

echo "<pre>";
print_r($array);
echo "</pre>";