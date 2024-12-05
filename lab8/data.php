<?php

$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getOS($userAgent) {
    $osArray = [
        'Windows' => 'Windows',
        'Macintosh' => 'Mac OS',
        'Linux' => 'Linux',
        'Android' => 'Android',
        'iPhone' => 'iOS',
    ];

    foreach ($osArray as $regex => $value) {
        if (preg_match("/$regex/i", $userAgent)) {
            return $value;
        }
    }
    return 'Unknown';
}

$userAgent = $_SERVER['HTTP_USER_AGENT'];
$os = getOS($userAgent);

$sql = "SELECT * FROM os_stats WHERE os_name = '$os'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $sql = "UPDATE os_stats SET visit_count = visit_count + 1 WHERE os_name = '$os'";
} else {

    $sql = "INSERT INTO os_stats (os_name) VALUES ('$os')";
}

$conn->query($sql);

$conn->close();
?>

<!doctype html>
<html>
<head>
    <title>Our Funky HTML Page</title>
    <meta name="description" content="Our first page">
    <meta name="keywords" content="html tutorial template">
    <script>
        function goBack() {
            window.location.href = "http://127.0.0.1/lab8/";
        }
    </script>
</head>
<body>
<h1>Some content</h1>
<h2>Some content</h2>
<h3>Some content</h3>
<h4>Some content</h4>
<button onclick="goBack()">Go Back</button>
</body>
</html>

