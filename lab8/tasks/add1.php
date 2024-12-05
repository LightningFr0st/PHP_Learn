<?php
// Список сайтов для проверки
$websites = array(
    'https://www.wikipedia.org/',
    'https://www.youtube.com/',
);

// Путь к лог-файлу
$logFile = 'log.txt';

// Проверяем каждый сайт
//while(true){
    foreach ($websites as $website) {
        $status = checkWebsite($website);
        $logMessage = date('Y-m-d H:i:s') . " - $website: $status" . PHP_EOL;
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
//    sleep(300);
//}

function checkWebsite($url) {
    ini_set('user_agent',"addTasks");
    $content = @file_get_contents($url);
    if ($content === FALSE) {
        return 'Site unavailable';
    } else {
        return 'Site available';
    }
}
?>
