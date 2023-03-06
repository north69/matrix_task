<?php

function quickSortArray(array $array): array
{
    $length = count($array);
    if ($length < 2) {
        return $array;
    }
    if ($length == 2) {
        $left = $array[0];
        $right = $array[1];
        if ($left > $right) {
            $array[0] = $right;
            $array[1] = $left;
        }
        return $array;
    }
    $pivot = $array[0];
    $less = [];
    $greater = [];
    for ($i = 1; $i < count($array); $i++) {
        if ($array[$i] <= $pivot) {
            $less[] = $array[$i];
        } else {
            $greater[] = $array[$i];
        }
    }
    return array_merge(quickSortArray($less), [$pivot], quickSortArray($greater));
}

$array = [3,4,1,8,10,6,7,5,2,9];

echo implode('_', quickSortArray($array)).PHP_EOL;