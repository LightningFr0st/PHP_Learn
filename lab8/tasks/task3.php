<?php
// Указываем каталоги для архивирования
$directories = array(
    'f1',
    'f2',
);

// Указываем имя и путь для архива
$archiveName = 'backup_' . date('Y-m-d') . '.zip'; // Например, backup_2024-05-15.zip
$archivePath = $archiveName;

// Создаем архив
$zip = new ZipArchive();
if ($zip->open($archivePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    foreach ($directories as $dir) {
        addDirToZip($dir, $zip, basename($dir));
    }
    $zip->close();
    echo 'Архив создан: ' . $archivePath;
} else {
    echo 'Не удалось создать архив';
}

// Функция для рекурсивного добавления содержимого каталога в архив
function addDirToZip($dir, $zip, $base = '') {
    $newBase = $base ? $base . '/' : '';
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file == '.' || $file == '..') continue;
        if (is_dir($dir . '/' . $file)) {
            addDirToZip($dir . '/' . $file, $zip, $newBase . $file);
        } else {
            $zip->addFile($dir . '/' . $file, $newBase . $file);
        }
    }
}
?>
