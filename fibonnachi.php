<?php

function fb($n)
{
    if ($n == 0){
        return 0;
    }
    if ($n == 1) {
        return 1;
    }
    $prev = 0;
    $current = 1;
    for ($i = 2; $i <= $n; $i++) {
        $res = $prev + $current;
        $prev = $current;
        $current = $res;
    }
    return $current;
}

echo implode('_', [fb(0),fb(1),fb(2),fb(3),fb(4),fb(5),fb(6),fb(7),fb(8),fb(9)]);
//0_1_1_2_3_5_8_13_21_34