<?php

if($argc!=2){
    echo 'Expected only one argument.';
}
else{
    if(is_numeric($argv[1])){

        // acquiring the amount
        $table_rows = +$argv[1];
        if(is_int($table_rows)){

            $result = "<table>\n";
            for($i = 0; $i < $table_rows; $i++){
                // print
                $result .= '    <tr>'.($i+1)."</tr>\n";
            }
            $result .= "</table>\n";

            echo $result;
        }
        else{
            echo "Invalid number.";
        }
    }
    else{
        echo "Invalid number.";
    }
}