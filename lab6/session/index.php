<?php
session_start();
require_once('TemplateGenerator.php');

$template_engine = new TemplateGenerator('');
$name = '';
$active_page_style = '';
$content = '</div>';

if(isset($_GET['link'])){
    $link = '';
    $active_page_id = $_GET['link'];
    switch($active_page_id){
        case 'index':
            $link = 'index.html';
            $name = 'Home';
            break;
        case 'about':
            $link= 'about.html';
            $name = 'About';
            break;
        case 'contact':
            $link = 'contact.html';
            $name = 'Contact';
            break;
        case 'photos':
            $link = 'photos.html';
            $name = 'Photos';
            break;
        case 'records':
            $link ='records.html';
            $name = 'Records';
            break;
    }
    $content = file_get_contents($link);

    $active_page_style =
        '#'.$active_page_id.'{
        background-color: #9CC;  
    }';
}


$template_engine->render(
    'template.html',
    [
        'name' => $name,
        'active-page-style' => $active_page_style,
        'content' => $content
    ]

);

$currentPage = $_SERVER['REQUEST_URI'];
// Проверка посещения страницы
if (hasVisited($currentPage)) {
    echo "Вы уже посещали эту страницу.";
} else {
    echo "Это первое посещение страницы.";
}
trackPage($currentPage);

echo '<form method="post">';
echo '<button type="submit" name="logout">Logout</button>';
echo '</form>';

if(isset($_POST['logout'])) {
    session_destroy();
}

// Функция для добавления посещенной страницы в сессию
function trackPage($page) {
    if (!isset($_SESSION['visited_pages'])) {
        $_SESSION['visited_pages'] = array();
    }
    $_SESSION['visited_pages'][$page] = true;
}

// Функция для проверки, посещал ли пользователь страницу
function hasVisited($page) {
    return isset($_SESSION['visited_pages'][$page]);
}
