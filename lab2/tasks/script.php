<?php

if (isset($_POST['message'])) {
    $go = true;
    $string = $_POST['message'];
    if (ctype_lower($string[0])) {
        Error(1);
        $go = false;
    }
    $checked = false;
    for ($i = 1; $i < mb_strlen($string, "UTF-8"); $i++) {
        if (!$checked && $string[$i] == ' ' && $string[$i - 1] != ',') {
            Error(2);
            $checked = true;
            $go = false;
        } elseif ($i == mb_strlen($string, "UTF-8") - 1 && $string[$i] != '.') {
            Error(3);
            $go = false;
        }
    }
    if ($go){
        $arr = explode(', ', $string);
        $n = count($arr) - 1;
        $arr[0][0] = mb_strtolower($arr[0][0], "UTF-8");
        $arr[$n][0] = mb_strtoupper($arr[$n][0], "UTF-8");
        $arr[0] .= '.';
        $arr[$n] = rtrim($arr[$n], '.');
        $arr = array_reverse($arr);
        $output = implode(', ', $arr);
        echo '<h3>'.$output.'</h3>';
    }
}

function Error($code): void
{
    switch ($code) {
        case 1:
            echo '<h3> Sentence does not start with a capital ru/eng letter </h3>';
            break;
        case 2:
            echo '<h3> Words should be separated with comas and spaces</h3>';
            break;
        case 3:
            echo '<h3> Sentence should end with point</h3>';
            break;
    }
}

/*
One, two, three, four.
One, two, three, four
One two three four.
*/
?>



