<?php

if($argc!=2){
    echo 'Expected only one argument.';
}
else{
    if(is_numeric($argv[1])){

        // initializing sum parameter
        $sum = 0;

        $num = +$argv[1];

        foreach(str_split($num) as $char){
            if(is_numeric($char)){
                $sum+=+$char;
            }
        }

        echo $sum;
    }
    else{
        echo "Invalid number";
    }
}