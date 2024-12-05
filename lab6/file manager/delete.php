<?php
$file = $_GET['file'];
$user = get_user();

// Проверка, существует ли файл
if (file_exists("uploads/$user/$file")) {
    // Удаление файла
    unlink("uploads/$user/$file");
    header("Location: file_manager.php?deleted=true");
}else {
    header("Location: file_manager.php?deleted=false");
}

exit;

function get_user() {
    if (isset($_COOKIE['user'])) {
        return $_COOKIE['user'];
    }
    return '';
}