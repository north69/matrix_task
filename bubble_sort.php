<?php

$array = [3,4,1,8,10,6,7,5,2,9];

function mySortArray($array)
{
    $last_index = count($array) - 1;
    $has_moving = true;
    while($has_moving) {
        $has_moving = false;
        for ($i = 0; $i < $last_index; $i++) {
            if ($array[$i] > $array[$i+1]) {
                $temp = $array[$i];
                $array[$i] = $array[$i+1];
                $array[$i+1] = $temp;
                $has_moving = true;
            }
        }
    }
    return $array;
}

echo implode('_', mySortArray($array)).PHP_EOL;

function bubble_sort(array $arr): array
{
    $last_index = count($arr) - 1;
    for ($i = 0; $i < $last_index; $i++) {
        for ($j = 0; $j < $last_index - $i; $j++) {
            $k = $j + 1;
            if ($arr[$k] < $arr[$j]) {
                // Swap elements at indices: $j, $k
                list($arr[$j], $arr[$k]) = array($arr[$k], $arr[$j]);
            }
        }
    }
    return $arr;
}
