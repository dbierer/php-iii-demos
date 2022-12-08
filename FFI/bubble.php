<?php
// create definitions
$bubble = FFI::cdef(
    "void bubble_sort(int [], int);",
    "./libbubble.so");

// create FFI\CData array
$max = 16;
$arr = FFI::new('int[' . $max . ']');

// populate array with random values
for ($i = 0; $i < $max; $i++)
    $arr[$i]->cdata = rand(0,9999);

var_dump($arr);

// perform bubble sort
$bubble->bubble_sort($arr, $max);

var_dump($arr);
