<?php
for ($i = 1; $i <= 100; $i++) {
    //ここからコードを書く
    if ($i % 3 == 0 && $i % 5 ==0) {
        echo '3の倍数であり、5の倍数' . "\n";
    } elseif ($i % 3 == 0) {
        echo '3の倍数' . "\n";
    } elseif ($i % 5 == 0) {
        echo '5の倍数' . "\n";
    } else {
    echo $i . "\n";
    }
}
