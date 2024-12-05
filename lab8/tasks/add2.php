<?php
// Параметры подключения к базе данных
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Путь к CSV файлу
$csvFile = "test.csv";

// Название таблицы в базе данных
$tableName = "cities";

// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Открытие CSV-файла
$file = fopen($csvFile, "r");
if (!$file) {
    die("Не удалось открыть CSV-файл");
}
$sql = "DELETE FROM $tableName";

$conn->query($sql);
// Чтение данных из CSV-файла и вставка их в базу данных
$columns = fgetcsv($file, 0, ';');
$columns = implode(",", array_map(function ($col) {
    return $col;
}, $columns));
while (($data = fgetcsv($file, 0, ';')) !== FALSE) {
    $values = implode(", ", array_map(function ($val) use ($conn) {
        return "'" . $conn->real_escape_string($val) . "'";
    }, $data));

    $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
    if ($conn->query($sql) !== TRUE) {
        echo "Ошибка при импорте данных: " . $conn->error;
    }
}

// Закрытие файла и соединения с базой данных
fclose($file);
$conn->close();

echo "Импорт завершен успешно!";
?>
