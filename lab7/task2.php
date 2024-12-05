<!DOCTYPE html>
<html>
<head>
    <title>lab7_2</title>
</head>
<body>
<h2>Metal downloader</h2>
<form method="post">
    <label for="directory">Download path :</label>
    <input type="text" id="directory" name="directory" value="bands/" required>
    <br><br>
    <label for="url">URL :</label>
    <input type="text" id="url" name="url" style="width: 500px" value="https://www.metal-archives.com/bands/Archspire/3540326229" required>
    <br><br>
    <button type="submit">Download</button>
</form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["directory"]) && isset($_POST["url"])) {
    ini_set('user_agent', 'Lab7');
    $directory = $_POST["directory"];
    $url = $_POST["url"];

    if (!is_dir($directory)) {
        echo "No such directory.";
        exit;
    }
    bandInfo($url, $directory);
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

function bandInfo($url, $saveToPath) : void {
    $tokens = explode('/',parse_url($url, PHP_URL_PATH));
    $bandName = str_replace('_',' ',$tokens[count($tokens) - 2]);
    $curDir = $saveToPath.$bandName;
    mkdir($curDir);
    downloadImages($url, $curDir,false);

    $html = file_get_contents($url);


    $albumsDir = $curDir . '/albums';
    mkdir($albumsDir);
    $memberDir = $curDir . '/members';
    mkdir($memberDir);

    //albums
    preg_match_all('~<a\shref=["\']([^"\']+)["\']><span>Complete discography~s',$html, $matches);
    $albums = $matches[1][0];
    inspectAlbums($albums,$albumsDir);

    //members
    inspectMembers($url, $memberDir);

    echo "$bandName: Completed";
}

function inspectMembers($url, $savePath) : void {
    $html = file_get_contents("$url#band_tab_members_current");
    preg_match_all('~<div\sid="band_tab_members_current">.*?</div>~s',$html, $matches);
    preg_match_all('~<a\shref=["\']([^"\']+)["\']\sclass="bold">~s', $matches[0][0], $matches);

    foreach ($matches[1] as $target){
        downloadImages($target, $savePath, true);
    }
}

function inspectAlbums($url, $savePath) : void {
    $html = file_get_contents($url);
    preg_match_all('~<a\shref=["\']([^"\']+)["\']\sclass="album">~s', $html, $matches);
    foreach ($matches[1] as $target){
        downloadImages($target, $savePath, true);
    }
}

function downloadImages($url, $saveToPath, $useURL) : void
{
    $html = file_get_contents($url);
    preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches);
    foreach ($matches[1] as $imageUrl) {

        $imageExtension = pathinfo($imageUrl, PATHINFO_EXTENSION);
        $ind = strpos($imageExtension, '?');
        $imageExtension = substr($imageExtension, 0, $ind);

        if ($imageExtension === 'jpg' || $imageExtension === 'png' || $imageExtension === 'jpeg') {
            if ($useURL){
                $tokens = explode('/',parse_url($url, PHP_URL_PATH));
                $filename = str_replace('_',' ',$tokens[count($tokens) - 2]).'.'.$imageExtension;
            }else if (strpos($imageUrl, 'logo')){
                $filename = 'logo.' . $imageExtension;
            }else{
                $filename = 'photo.' . $imageExtension;
            }

            $fullPath = $saveToPath .'/'. $filename;

            $imageData = file_get_contents($imageUrl);
            if ($imageData !== false) {
                if (file_put_contents($fullPath, $imageData) === false) {
                    echo "Save error. $imageUrl<br />";
                }
            } else {
                echo 'Download error.<br />';
            }
        }
    }
}
?>
