<!DOCTYPE html>
<html>
<head>
    <title>Обработка текста</title>
    <style>
        .red {
            color: red;
        }

        .green {
            color: green;
        }

        .underline {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<form method="post" action="">
    <textarea name="text" rows="8" cols="50"></textarea><br>
    <input type="submit" name="submit" value="Обработать">
</form>

<?php
if (isset($_POST['text'])) {
    $text = $_POST['text'];
    $correct = preg_replace_callback('/(^|([\.\?!]\s*))([A-Z]+[a-z]*)/', function ($matches) {
        $matches[0] = preg_replace_callback('/([A-Z]+[a-z]*)/', function ($matches2){
            return '<span class = "underline">' . $matches2[0] . '</span>';
        },$matches[0]);
        return $matches[0];
    }, $text);
    $correct = preg_replace_callback('/([^\.\?!])(\s+)([A-Z]+[a-z]*)/', function ($matches) {
        $matches[0] = preg_replace_callback('/([A-Z]+[a-z]*)/', function ($matches2){
            return '<span class = "red">' . $matches2[0] . '</span>';
        },$matches[0]);
        return $matches[0];
    }, $correct);
    $correct = preg_replace_callback('/\d{4,}/', function ($matches) {
        return '<span class = "green">' . $matches[0] . '</span>';
    }, $correct);
    echo $correct;
}
?>
</body>
</html>

<!-- Hello, HOW 1234. ARE you YOU. 1234 123 hHHH. hq. -->