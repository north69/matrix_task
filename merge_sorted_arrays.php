<?php

$a = [1,3,5,8];
$b = [2,4,6,9];

function mergeTwoSortedArrays($a, $b): array
{
    $array = [];
    $i = 0; $j = 0;
    while ($i < count($a) && $j < count($b)) {
        if ($a[$i] < $b[$j]) {
            $array[] = $a[$i];
            $i++;
        } else {
            $array[] = $b[$j];
            $j++;
        }
    }
    // if there are any items, copy them to the array
    while ($i < count($a)) {
        $array[] = $a[$i];
        $i++;
    }
    while ($j < count($b)) {
        $array[] = $b[$j];
        $j++;
    }
    return $array;
}


echo implode('_', mergeTwoSortedArrays($a, $b)).PHP_EOL;
