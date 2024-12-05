<?php

// $len_str is an array that maps the length of
// the string to the array of strings that have
// that length
$len_str = array();
$max_len = 0;

// iterating through the arguments
for ($i = 1; $i<$argc;$i++){

    $curr_len = mb_strlen($argv[$i]);

    // change the max length if the current length is larger
    if($curr_len>$max_len){
        $max_len = $curr_len;

        // initialize the array for a new length
        $len_str[$max_len] = array();
    }

    // add current string to the array
    $len_str[$curr_len][] = $argv[$i];
}

// if there were any arguments, the array will be set
if(isset($len_str[$max_len])){
    $result = '';

    // concatenating all the strings into one
    foreach($len_str[$max_len] as $value){
        $result .= $value.' ';
    }
    echo $result;
}