<?php

// тут я не смог догадаться как смержить два отсортированных массива
function myMergeSortArray($array)
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
    $half_index = round($length/2);
    $left = array_slice($array, 0, $half_index);
    $right = array_slice($array, $half_index);
    $sorted_left = myMergeSortArray($left);
    $sorted_right = myMergeSortArray($right);
    $merged = array_merge($sorted_left, $sorted_right);
    $last_index = $length - 1;
    for ($i=0; $i < $last_index; $i++) {
        for ($j=0; $j < $last_index - $i; $j++) {
            $k = $j + 1;
            $next_value = $merged[$k];
            $value = $merged[$j];
            if ($next_value < $value) {
                $merged[$k] = $value;
                $merged[$j] = $next_value;
            }
        }
    }
    return $merged;
}

function merge(&$arr, $left_index, $middle_index, $right_index)
{
    // Count numbers in left and right half
    $item_count_from_left = $middle_index - $left_index + 1;
    $item_count_from_middle = $right_index - $middle_index;

    /* create temp arrays */
    $left_half = [];
    $right_half = [];
    /* Copy data to temp arrays L[] and R[] */
    for ($i = 0; $i < $item_count_from_left; $i++) {
        $left_half[$i] = $arr[$left_index + $i];
    }
    for ($j = 0; $j < $item_count_from_middle; $j++) {
        $right_half[$j] = $arr[$middle_index + 1 + $j];
    }

    /* Merge the temp arrays back into arr[l..r]*/
    $i = 0; // Initial index of first subarray
    $j = 0; // Initial index of second subarray
    $k = $left_index; // Initial index of merged subarray
    while ($i < $item_count_from_left && $j < $item_count_from_middle) {
        if ($left_half[$i] <= $right_half[$j]) {
            $arr[$k] = $left_half[$i];
            $i++;
        }
        else {
            $arr[$k] = $right_half[$j];
            $j++;
        }
        $k++;
    }

    /* Copy the remaining elements of L[], if there are any */
    while ($i < $item_count_from_left) {
        $arr[$k] = $left_half[$i];
        $i++;
        $k++;
    }

    /* Copy the remaining elements of R[], if there are any */
    while ($j < $item_count_from_middle) {
        $arr[$k] = $right_half[$j];
        $j++;
        $k++;
    }
}

function mergeSort(&$arr, $left_index = null, $right_index = null)
{
    if (is_null($left_index)) {
        $left_index = 0;
    }
    if (is_null($right_index)) {
        $right_index = count($arr) - 1;
    }
    if ($left_index < $right_index) {
        // Same as (l+r)/2, but avoids overflow for large l and h
        $middle_index = (int)(($right_index+$left_index)/2);

        // Sort first and second halves
        mergeSort($arr, $left_index, $middle_index);
        mergeSort($arr, $middle_index + 1, $right_index);

        merge($arr, $left_index, $middle_index, $right_index);
    }
}

$array = [3,4,1,8,10,6,7,5,2,9];

mergeSort($array);
echo implode('_', $array).PHP_EOL;