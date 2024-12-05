<?php

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