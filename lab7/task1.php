<!DOCTYPE html>
<html>
<head>
    <title>lab7_1</title>
</head>
<body>
<h2>Images downloader</h2>
<form method="post">
    <label for="directory">Download path:</label>
    <input type="text" id="directory" name="directory" value="downloads/" required>
    <br><br>
    <label for="url">URL :</label>
    <input style="width: 500px" type="text" id="url" name="url"
           value="https://en.wikipedia.org/wiki/Abydos,_Egypt" required>
    <br><br>
    <button type="submit">Download</button>
</form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ini_set('user_agent', 'Lab7');
    $directory = $_POST["directory"];
    $url = $_POST["url"];

    if (!empty($directory) && !empty($url)) {
        if (!is_dir($directory)) {
            echo "Указанный каталог не существует.";
            exit;
        }
        downloadImages($url, $directory);
        echo 'Images downloaded';
    } else {
        echo "Fill all fields";
    }
}

function getDomainFromUrl($url) : string | null
{
    $parsedUrl = parse_url($url);
    if (isset($parsedUrl['scheme']) && isset($parsedUrl['host'])) {
        return $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
    } else {
        return null;
    }
}

function getUID() : string
{
    static $cur = 0;
    return $cur++;
}

function downloadImages($url, $saveToPath) : void
{
    $html = file_get_contents($url);
    preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches);
    $domainurl = getDomainFromUrl($url);
    foreach ($matches[1] as $imageUrl) {
        if ($imageUrl[1] === "/") {
            $fullImageUrl = 'https:' . $imageUrl;
        } else if (substr($imageUrl, 0, 4) === 'http') {
            $fullImageUrl = $imageUrl;
        } else {
            $fullImageUrl = $domainurl . $imageUrl;
        }
        $imageExtension = pathinfo($imageUrl, PATHINFO_EXTENSION);
        $ind = strpos($imageExtension, '?');
        if ($ind != false) {
            $imageExtension = substr($imageExtension, 0, $ind);
        }
        if ($imageExtension === 'jpg' || $imageExtension === 'png' || $imageExtension === 'jpeg') {
            $filename = getUID() . '.' . $imageExtension;
            $fullPath = $saveToPath . $filename;
            $imageData = file_get_contents($fullImageUrl);
            if ($imageData !== false) {
                if (file_put_contents($fullPath, $imageData) !== false) {
                } else {
                    echo "Save error. $fullImageUrl<br />";
                }
            } else {
                echo 'Download error.<br />';
            }
        }
    }
}
?>