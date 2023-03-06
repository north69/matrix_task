<?php

function binarySearch($item, $array): ?int
{
    $first_index = 0;
    $last_index = count($array) - 1;

    while ($first_index <= $last_index)
    {
        $middle_index = round(($last_index+$first_index)/2);

        $guess = $array[$middle_index];

        if ($item == $guess) {
            return $middle_index;
        }
        if ($guess > $item) {
            $last_index = $middle_index - 1;
            continue;
        }
        if ($guess < $item) {
            $first_index = $middle_index + 1;
        }
    }
    return null;
}

function myBinarySearch($item, $array, $first_index = null, $last_index = null): ?int
{
    if (is_null($first_index)) {
        $first_index = 0;
    }
    if (is_null($last_index)) {
        $last_index = count($array) - 1;
    }
    if ($first_index == $last_index && $item == $array[$first_index]) {
        return $first_index;
    }
    if ($first_index == $last_index && $item !== $array[$first_index]) {
        return null;
    }

    $middle_index = $last_index - round(($last_index-$first_index+1)/2) + 1;

    if ($item == $array[$middle_index]) {
        return $middle_index;
    }
    if ($item > $array[$middle_index]) {
        $first_index = $middle_index + 1;
        return myBinarySearch($item, $array, $first_index, $last_index);
    }
    if ($item < $array[$middle_index]) {
        $last_index = $middle_index - 1;
        return myBinarySearch($item, $array, $first_index, $last_index);
    }
    return null;
}

$array = [1,2,3,4,6,7,9,11,14,16];

var_dump(myBinarySearch(1,$array));//0
var_dump(myBinarySearch(2,$array));//1
var_dump(myBinarySearch(3,$array));//2
var_dump(myBinarySearch(4,$array));//3
var_dump(myBinarySearch(6,$array));//4
var_dump(myBinarySearch(7,$array));//5
var_dump(myBinarySearch(9,$array));//6
var_dump(myBinarySearch(11,$array));//7
var_dump(myBinarySearch(14,$array));//8
var_dump(myBinarySearch(16,$array));//9
var_dump(myBinarySearch(17,$array));//null
var_dump(myBinarySearch(15,$array));//null