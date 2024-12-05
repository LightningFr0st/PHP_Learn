<?php
if (isset($_POST['set1']) && isset($_POST['set2'])) {
    $str1 = $_POST['set1'];
    $str2 = $_POST['set2'];
    $arr1 = explode(' ', $str1);
    $arr2 = explode(' ', $str2);
    echo '<h1>' . implode(' ', $arr1);
    for ($i = 0; $i < count($arr2); $i++) {
        $res = in_array($arr2[$i], $arr1);
        if (!$res) {
            echo ' ' . $arr2[$i];
        }
    }
    echo '</h1>';
}