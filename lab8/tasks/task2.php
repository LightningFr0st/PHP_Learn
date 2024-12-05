<?php
// Оригинальное изображение
$originalImage = 'original.jpg';

// Новый размер для превью
$thumbWidth = 200;
$thumbHeight = 200;

// Определение типа изображения
$image_info = getimagesize($originalImage);
$image_type = $image_info[2];

// Создание изображения на основе исходного файла
switch ($image_type) {
    case IMAGETYPE_JPEG:
        $sourceImage = imagecreatefromjpeg($originalImage);
        break;
    case IMAGETYPE_GIF:
        $sourceImage = imagecreatefromgif($originalImage);
        break;
    case IMAGETYPE_PNG:
        $sourceImage = imagecreatefrompng($originalImage);
        break;
    default:
        die('Unsupported image type');
}

// Получение размеров исходного изображения
$sourceWidth = imagesx($sourceImage);
$sourceHeight = imagesy($sourceImage);

// Создание пустого холста для превью
$thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);

// Масштабирование и копирование исходного изображения на холст превью
imagecopyresampled($thumbImage, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $sourceWidth, $sourceHeight);

// Вывод превью в браузер или сохранение в файл
header('Content-Type: image/jpeg');
imagejpeg($thumbImage);

// Освобождение памяти
imagedestroy($sourceImage);
imagedestroy($thumbImage);
