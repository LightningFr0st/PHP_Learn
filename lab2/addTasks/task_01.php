<?php

$result = '';

for($i = 1; $i < $argc; $i++)
{
    // acquiring the current value
    $temp = $argv[$i];
    $type_value ="";

    // checking if the string is a numeric string or not
    if(is_numeric($temp)){

        // converting the string into a numeric type value
        $temp = +$temp;
        if(is_int($temp)){
            $type_value='int';
        }
        else{
            $type_value ='float';
        }
    }
    else{
        $type_value='string';
    }

    // outputting the result
    $result.= 'Value: '.$temp.' Type: '.$type_value." \n";
}
echo $result;