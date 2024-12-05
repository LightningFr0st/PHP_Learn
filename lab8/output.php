<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT os_name, visit_count FROM os_stats ORDER BY visit_count DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>OS Statistics</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<h1>Statistics of Operating Systems</h1>
<table>
    <tr>
        <th>Operating System</th>
        <th>Visits</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["os_name"] . "</td><td>" . $row["visit_count"] . "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No data available</td></tr>";
    }
    $conn->close();
    ?>
</table>
</body>
</html>