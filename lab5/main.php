<?php
$password = "";
$servername = "localhost";
$username = "root";
$dbname = "myDB";
// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Обработка данных из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Проверка, существует ли пользователь с таким именем
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Пользователь не существует, проверяем соответствие паролей
        if ($new_password == $confirm_password) {
            // Хэшируем пароль
            $hashed_password = sha1($new_password);

            // Добавляем пользователя в базу данных
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
            if ($conn->query($sql) === TRUE) {
                echo "New user added successfully";
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
            // Обновляем пароль
            $new_hashed_password = sha1($new_password);
            $sql = "UPDATE users SET password='$new_hashed_password' WHERE username='$username'";
            if ($conn->query($sql) === TRUE) {
                echo "Password updated successfully";
            } else {
                echo "Error updating password: " . $conn->error;
            }
        } else {
            echo "Incorrect current password";
        }
    }
}

$conn->close();
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
    Current Password: <input type="password" name="current_password"><br><br>
    New Password: <input type="password" name="new_password"><br><br>
    Confirm New Password: <input type="password" name="confirm_password"><br><br>
    <input type="submit" name="submit" value="Submit">
</form>

</body>
</html>
