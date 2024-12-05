<?php
$user = get_user();
$target_dir = "uploads/".$user."/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 0;

if(isset($_POST["submit"])) {
    $uploadOk = 1;
}
// Проверка существует ли файл
if (file_exists($target_file)) {
    header("Location: file_manager.php?uploaded=false");
    $uploadOk = 0;
}

// Проверка $uploadOk
if ($uploadOk == 0) {
    header("Location: file_manager.php?uploaded=false");
// Если все в порядке, попытка загрузки файла
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        header("Location: file_manager.php?uploaded=true");
    } else {
        header("Location: file_manager.php?uploaded=false");
    }
}


function get_user() {
    if (isset($_COOKIE['user'])) {
        return $_COOKIE['user'];
    }
    return '';
}
