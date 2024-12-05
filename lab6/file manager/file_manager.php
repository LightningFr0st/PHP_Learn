<?php
$user = get_user();

if (isset($_GET['deleted']) && $_GET['deleted']) {
    echo "<p style='margin-bottom: 50px'>File has been successfully deleted.</p>";
}
if (isset($_GET['uploaded']) && $_GET['uploaded']) {
    echo "<p style='margin-bottom: 50px'>File has been successfully uploaded.</p>";
}

// Форма для загрузки файла
echo '<form action="upload.php?user='.$user.'" method="post" enctype="multipart/form-data">';
echo '<input type="file" name="fileToUpload" id="fileToUpload">';
echo '<input type="submit" value="Upload File" name="submit">';
echo '</form>';

// Список загруженных файлов
$files = scandir("uploads/$user/");
echo "<ul>";
foreach ($files as $file) {
    if ($file != "." && $file != "..") {
        echo "<li><a href='uploads/$user/$file' download>$file</a> <a href='delete.php?file=$file'>Delete</a></li>";
    }
}

echo "</ul>";

echo '<form style="margin-top: 100px" method="post" action="index.php">';
echo '<button type="submit" name="logout">Logout</button>';
echo '</form>';
function get_user() {
    if (isset($_COOKIE['user'])) {
        return $_COOKIE['user'];
    }
    return '';
}

function logout() {
    // Устанавливаем время устаревания cookie в прошлое
    setcookie('username', '', time() - 3600, '/');
}