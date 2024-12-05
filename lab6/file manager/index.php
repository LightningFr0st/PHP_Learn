<?php
$password = "";
$servername = "";
$username = "";
$dbname = "";
// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Обработка данных из формы
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"])) {
    $username = $_POST["username"];
    $current_password = $_POST["current_password"];
    $confirm_password = $_POST["confirm_password"];

    // Проверка, существует ли пользователь с таким именем
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Пользователь не существует, проверяем соответствие паролей
        if ($current_password == $confirm_password) {
            // Хэшируем пароль
            $hashed_password = sha1($current_password);

            // Добавляем пользователя в базу данных
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
            if ($conn->query($sql) === TRUE) {
                echo "New user added successfully";
                mkdir('./uploads/'.$username);
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Passwords do not match";
        }
    } else {
        // Пользователь существует, проверяем текущий пароль
        $user_row = $result->fetch_assoc();
        $stored_password = $user_row["password"];
        if (sha1($current_password) == $stored_password) {
            set_user_cookie($username);
            header("Location: file_manager.php?user=".$username);
        } else {
            echo "Incorrect current password";
        }
    }
}

$conn->close();

function set_user_cookie($username) {
    // Время жизни cookie - 1 час
    $expire = time() + 3600;
    setcookie('user', $username, $expire, '/');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>

<h2>Change Password</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Username: <input type="text" name="username"><br><br>
    Password: <input type="password" name="current_password"><br><br>
    Confirm Password: <input type="password" name="confirm_password"><br><br>
    <input type="submit" name="submit" value="Submit">
</form>

</body>
</html>
